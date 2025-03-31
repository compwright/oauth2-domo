<?php

namespace Compwright\OAuth2\Domo;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\ResourceOwnerAccessTokenInterface;
use League\OAuth2\Client\Tool\QueryBuilderTrait;
use PHPUnit\Framework\TestCase;

class DomoProviderTest extends TestCase
{
    use QueryBuilderTrait;

    protected DomoProvider $provider;

    protected function setUp(): void
    {
        $factory = new DomoProviderFactory();
        $this->provider = $factory->new('mock_client_id', 'mock_secret');
    }

    public function testGetAccessToken(): void
    {
        $response = new Response(
            200,
            ['content-type' => 'application/json'],
            '{"access_token":"mock_access_token", "scope":"data", "token_type":"bearer"}'
        );

        $client = $this->createMock(ClientInterface::class);
        $client->expects($this->once())
            ->method('send')
            ->willReturn($response);

        $this->provider->setHttpClient($client);
        $token = $this->provider->getAccessToken('client_credentials');

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNull($token->getExpires());
        $this->assertNull($token->getRefreshToken());

        $this->assertInstanceOf(ResourceOwnerAccessTokenInterface::class, $token);
        $this->assertNull($token->getResourceOwnerId());
    }

    public function testUserData(): void
    {
        $id = (string) rand(1000, 9999);
        $name = uniqid();
        $email = uniqid();

        $postResponse = new Response(
            200,
            ['content-type' => 'application/x-www-form-urlencoded'],
            $this->buildQueryString([
                'access_token' => 'mock_access_token',
                'expires' => 3600,
                'refresh_token' => 'mock_refresh_token',
            ])
        );

        $userResponse = new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode(compact('id', 'name', 'email')) ?: ''
        );

        $client = $this->createMock(ClientInterface::class);
        $client->expects($this->exactly(2))
            ->method('send')
            ->willReturn($postResponse, $userResponse);
        $this->provider->setHttpClient($client);

        $token = $this->provider->getAccessToken('client_credentials');

        $this->assertInstanceOf(AccessToken::class, $token);

        $user = $this->provider->getResourceOwner($token);

        $this->assertInstanceOf(DomoResourceOwner::class, $user);

        $this->assertEquals($id, $user->getId());
        $this->assertEquals($name, $user->getName());
        $this->assertEquals($email, $user->getEmail());

        $this->assertEquals(
            json_encode(compact('id', 'name', 'email')),
            json_encode($user)
        );
    }

    public function testExceptionThrownWhenErrorObjectReceived(): void
    {
        $status = rand(400, 599);
        $postResponse = new Response(
            $status,
            ['content-type' => 'application/json'],
            json_encode([
                'message' => 'Validation Failed',
                'errors' => [
                    ['resource' => 'Issue', 'field' => 'title', 'code' => 'missing_field'],
                ],
            ]) ?: ''
        );

        $client = $this->createMock(ClientInterface::class);
        $client->expects($this->once())
            ->method('send')
            ->willReturn($postResponse);
        $this->provider->setHttpClient($client);

        $this->expectException(DomoIdentityProviderException::class);

        $this->provider->getAccessToken('client_credentials');
    }

    public function testExceptionThrownWhenOAuthErrorReceived(): void
    {
        $postResponse = new Response(
            200,
            ['content-type' => 'application/json'],
            json_encode([
                "error" => "bad_verification_code",
                "error_description" => "The code passed is incorrect or expired."
            ]) ?: ''
        );

        $client = $this->createMock(ClientInterface::class);
        $client->expects($this->once())
            ->method('send')
            ->willReturn($postResponse);
        $this->provider->setHttpClient($client);

        $this->expectException(DomoIdentityProviderException::class);

        $this->provider->getAccessToken('client_credentials');
    }
}

<?php

namespace Compwright\OAuth2\Domo;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\ResourceOwnerAccessTokenInterface;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

class DomoProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public string $apiDomain = 'https://api.domo.com';

    public function getBaseAuthorizationUrl(): string
    {
        throw new RuntimeException('Authorization grant not supported');
    }

    /**
     * Get access token url to retrieve token
     *
     * @param array<string, string> $params
     */
    public function getBaseAccessTokenUrl(array $params = []): string
    {
        return $this->apiDomain . '/oauth/token';
    }

    public function getResourceOwnerDetailsUrl(ResourceOwnerAccessTokenInterface $token): string
    {
        return $this->apiDomain . '/v1/users/' . urlencode($token->getResourceOwnerId() ?? '');
    }

    /**
     * Get the default scopes used by this provider.
     *
     * This should not be a complete list of all scopes, but the minimum
     * required for the provider user interface!
     *
     * @return string[]
     */
    protected function getDefaultScopes(): array
    {
        return [
            'data',
        ];
    }

    /**
     * Check a provider response for errors.
     *
     * @param array<string, ?string> $data     Parsed response data
     *
     * @throws DomoIdentityProviderException
     */
    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() >= 400) {
            throw DomoIdentityProviderException::clientException($response, $data);
        }
        if (isset($data['error'])) {
            throw DomoIdentityProviderException::oauthException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array<string, ?string> $response
     */
    protected function createResourceOwner(array $response, AccessToken $token): DomoResourceOwner
    {
        return new DomoResourceOwner($response);
    }
}

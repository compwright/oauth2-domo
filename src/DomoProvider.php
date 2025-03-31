<?php

namespace Compwright\OAuth2\Domo;

use League\OAuth2\Client\Provider\GenericProvider;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Token\ResourceOwnerAccessTokenInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @method DomoResourceOwner getResourceOwner(AccessToken $token)
 */
class DomoProvider extends GenericProvider
{
    public const ACCESS_TOKEN_RESOURCE_OWNER_ID = 'userId';

    /**
     * @inheritdoc
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    public function getResourceOwnerDetailsUrl(ResourceOwnerAccessTokenInterface $token): string
    {
        return parent::getResourceOwnerDetailsUrl($token) . urlencode($token->getResourceOwnerId() ?? '');
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
        if (isset($data['error'])) {
            throw DomoIdentityProviderException::oauthException($response, $data);
        }
        if ($response->getStatusCode() >= 400) {
            throw DomoIdentityProviderException::clientException($response, $data);
        }
    }

    /**
     * Generate a user object from a successful user details request.
     *
     * @param array<string, ?string> $response
     */
    protected function createResourceOwner(array $response, AccessToken $token): DomoResourceOwner
    {
        return new DomoResourceOwner($response, 'id');
    }
}

<?php

namespace Compwright\OAuth2\Domo;

use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Psr\Http\Message\ResponseInterface;

class DomoIdentityProviderException extends IdentityProviderException
{
    /**
     * Creates client exception from response.
     *
     * @param array<string, ?string> $data Parsed response data
     */
    public static function clientException(ResponseInterface $response, array $data): self
    {
        return new self(
            $data['message'] ?? $response->getReasonPhrase(),
            $response->getStatusCode(),
            (string) $response->getBody()
        );
    }

    /**
     * Creates oauth exception from response.
     *
     * @param array<string, ?string> $data Parsed response data
     */
    public static function oauthException(ResponseInterface $response, array $data): self
    {
        return new self(
            $data['error'] ?? $response->getReasonPhrase(),
            $response->getStatusCode(),
            (string) $response->getBody()
        );
    }
}

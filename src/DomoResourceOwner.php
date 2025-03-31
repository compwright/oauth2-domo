<?php

namespace Compwright\OAuth2\Domo;

use Countable;
use JsonSerializable;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;

class DomoResourceOwner implements ResourceOwnerInterface, Countable, JsonSerializable
{
    /**
     * @param array<string, int|string|null> $response
     */
    public function __construct(protected array $response = [])
    {
    }

    public function count(): int
    {
        return count($this->response);
    }

    /**
     * @return array<string, int|string|null>
     */
    public function jsonSerialize(): array
    {
        return $this->response;
    }

    /**
     * Get resource owner id
     */
    public function getId(): string
    {
        return strval($this->response['id'] ?? '');
    }

    /**
     * Get resource owner email
     */
    public function getEmail(): string
    {
        return strval($this->response['email'] ?? '');
    }

    /**
     * Get resource owner name
     */
    public function getName(): string
    {
        return strval($this->response['name'] ?? '');
    }

    /**
     * Return all of the owner details available as an array.
     *
     * @return array<string, int|string|null>
     */
    public function toArray(): array
    {
        return $this->jsonSerialize();
    }
}

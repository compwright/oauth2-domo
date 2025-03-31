<?php

namespace Compwright\OAuth2\Domo;

use JsonSerializable;
use League\OAuth2\Client\Provider\GenericResourceOwner;

class DomoResourceOwner extends GenericResourceOwner implements JsonSerializable
{
    /**
     * @return array<string, int|string|null>
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function getTitle(): string
    {
        return strval($this->response['title'] ?? '');
    }

    public function getEmail(): string
    {
        return strval($this->response['email'] ?? '');
    }

    public function getRole(): string
    {
        return strval($this->response['role'] ?? '');
    }

    public function getPhone(): string
    {
        return strval($this->response['phone'] ?? '');
    }

    public function getName(): string
    {
        return strval($this->response['name'] ?? '');
    }

    public function getDepartment(): string
    {
        return strval($this->response['department'] ?? '');
    }

    public function getRoleId(): int
    {
        return intval($this->response['roleId'] ?? '');
    }

    public function getCreatedAt(): string
    {
        return strval($this->response['createdAt'] ?? '');
    }

    public function getUpdatedAt(): string
    {
        return strval($this->response['updatedAt'] ?? '');
    }

    public function getDeleted(): bool
    {
        return boolval($this->response['deleted'] ?? '');
    }

    public function getImage(): string
    {
        return strval($this->response['image'] ?? '');
    }

    /**
     * @return array<array{id:int, name:string}>
     */
    public function getGroups(): array
    {
        return (array) ($this->response['groups'] ?? []);
    }
}

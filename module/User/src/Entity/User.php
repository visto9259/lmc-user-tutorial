<?php

namespace User\Entity;

class User extends \LmcUser\Entity\User
{
    protected ?string $tagline = null;

    protected array $roles = [];

    protected ?string $fullName;

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): User
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(?string $tagline): User
    {
        $this->tagline = $tagline;
        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }
}

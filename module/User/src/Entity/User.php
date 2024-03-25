<?php

namespace User\Entity;

class User extends \LmcUser\Entity\User
{
    protected ?string $tagline = null;

    public function getTagline(): ?string
    {
        return $this->tagline;
    }

    public function setTagline(?string $tagline): User
    {
        $this->tagline = $tagline;
        return $this;
    }
}

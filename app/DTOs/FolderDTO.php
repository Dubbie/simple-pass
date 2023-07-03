<?php

namespace App\DTOs;

class FolderDTO
{
    private string $name;
    private ?string $description = null;
    private int $user_id;
    private ?int $parent_id = null;

    /**
     * Get the value of name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the value of name
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of user_id
     */
    public function getUserId(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     */
    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * Get the value of parent_id
     */
    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    /**
     * Set the value of parent_id
     */
    public function setParentId(?int $parent_id): self
    {
        $this->parent_id = $parent_id;

        return $this;
    }
}

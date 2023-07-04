<?php

namespace App\DTOs;

class PasswordEntryDTO
{
    private ?string $title = null;
    private ?string $username = null;
    private ?string $password = null;
    private ?string $url = null;
    private ?string $notes = null;
    private int $user_id;
    private int $folder_id;

    /**
     * Get the value of title
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     */
    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of url
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Set the value of url
     */
    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get the value of notes
     */
    public function getNotes(): ?string
    {
        return $this->notes;
    }

    /**
     * Set the value of notes
     */
    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

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
     * Get the value of folder_id
     */
    public function getFolderId(): int
    {
        return $this->folder_id;
    }

    /**
     * Set the value of folder_id
     */
    public function setFolderId(int $folder_id): self
    {
        $this->folder_id = $folder_id;

        return $this;
    }
}

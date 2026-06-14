<?php

class Model
{
    private int $id;
    private string $title;
    private string $notes;
    private bool $isActive;
    private string $creationDateTime;
    private string $editDateTime;

    public function __construct
    (
        int $id = 0,
        string $title = "",
        string $notes = "",
        bool $isActive = true,
        string $creationDateTime = "",
        string $editDateTime = ""
    ) 
    {
        $this->id = $id;
        $this->title = $title;
        $this->notes = $notes;
        $this->isActive = $isActive;
        $this->creationDateTime = $creationDateTime;
        $this->editDateTime = $editDateTime;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): void
    {
        $this->notes = $notes;
    }

    public function getIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    public function getCreationDateTime(): string
    {
        return $this->creationDateTime;
    }

    public function setCreationDateTime(string $creationDateTime): void
    {
        $this->creationDateTime = $creationDateTime;
    }

    public function getEditDateTime(): string
    {
        return $this->editDateTime;
    }

    public function setEditDateTime(string $editDateTime): void
    {
        $this->editDateTime = $editDateTime;
    }
}
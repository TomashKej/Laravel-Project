<?php

include_once("Model.php");

class Task extends Model
{
    private bool $isDone;
    private string $startDateTime;
    private string $description;
    private string $deadline;
    private int $internalEventId;

    public function __construct(
        int $id = 0,
        string $title = "",
        bool $isDone = false,
        string $startDateTime = "",
        string $description = "",
        string $deadline = "",
        int $internalEventId = 0,
        string $creationDateTime = "",
        string $editDateTime = "",
        string $notes = "",
        bool $isActive = true
    ) {
        parent::__construct(
            $id,
            $title,
            $notes,
            $isActive,
            $creationDateTime,
            $editDateTime
        );

        $this->isDone = $isDone;
        $this->startDateTime = $startDateTime;
        $this->description = $description;
        $this->deadline = $deadline;
        $this->internalEventId = $internalEventId;
    }

    public function getIsDone(): bool
    {
        return $this->isDone;
    }

    public function setIsDone(bool $isDone): void
    {
        $this->isDone = $isDone;
    }

    public function getStartDateTime(): string
    {
        return $this->startDateTime;
    }

    public function setStartDateTime(string $startDateTime): void
    {
        $this->startDateTime = $startDateTime;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDeadline(): string
    {
        return $this->deadline;
    }

    public function setDeadline(string $deadline): void
    {
        $this->deadline = $deadline;
    }

    public function getInternalEventId(): int
    {
        return $this->internalEventId;
    }

    public function setInternalEventId(int $internalEventId): void
    {
        $this->internalEventId = $internalEventId;
    }
}
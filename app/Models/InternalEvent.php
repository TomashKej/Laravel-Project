<?php

include_once("Model.php");

class InternalEvent extends Model
{
    private string $link;
    private bool $isPublic;
    private bool $isCancelled;
    private string $eventDateTime;
    private string $publishDateTime;
    private string $shortDescription;
    private string $contentHTML;
    private string $metaDescription;
    private string $metaTags;

    public function __construct(
        int $id = 0,
        string $title = "",
        string $link = "",
        bool $isPublic = false,
        bool $isCancelled = false,
        string $eventDateTime = "",
        string $publishDateTime = "",
        string $shortDescription = "",
        string $contentHTML = "",
        string $metaDescription = "",
        string $metaTags = "",
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

        $this->link = $link;
        $this->isPublic = $isPublic;
        $this->isCancelled = $isCancelled;
        $this->eventDateTime = $eventDateTime;
        $this->publishDateTime = $publishDateTime;
        $this->shortDescription = $shortDescription;
        $this->contentHTML = $contentHTML;
        $this->metaDescription = $metaDescription;
        $this->metaTags = $metaTags;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): void
    {
        $this->link = $link;
    }

    public function getIsPublic(): bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): void
    {
        $this->isPublic = $isPublic;
    }

    public function getIsCancelled(): bool
    {
        return $this->isCancelled;
    }

    public function setIsCancelled(bool $isCancelled): void
    {
        $this->isCancelled = $isCancelled;
    }

    public function getEventDateTime(): string
    {
        return $this->eventDateTime;
    }

    public function setEventDateTime(string $eventDateTime): void
    {
        $this->eventDateTime = $eventDateTime;
    }

    public function getPublishDateTime(): string
    {
        return $this->publishDateTime;
    }

    public function setPublishDateTime(string $publishDateTime): void
    {
        $this->publishDateTime = $publishDateTime;
    }

    public function getShortDescription(): string
    {
        return $this->shortDescription;
    }

    public function setShortDescription(string $shortDescription): void
    {
        $this->shortDescription = $shortDescription;
    }

    public function getContentHTML(): string
    {
        return $this->contentHTML;
    }

    public function setContentHTML(string $contentHTML): void
    {
        $this->contentHTML = $contentHTML;
    }

    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): void
    {
        $this->metaDescription = $metaDescription;
    }

    public function getMetaTags(): string
    {
        return $this->metaTags;
    }

    public function setMetaTags(string $metaTags): void
    {
        $this->metaTags = $metaTags;
    }
}
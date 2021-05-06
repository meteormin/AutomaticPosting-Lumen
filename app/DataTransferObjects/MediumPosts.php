<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Abstracts\Dto;
use App\DataTransferObjects\Utils\ArrController;

class MediumPosts extends Dto
{
    /**
     * @var string $title
     */
    protected string $title;

    /**
     * @var string $contentFormat
     */
    protected string $contentFormat = 'html';

    /**
     * @var string $contents
     */
    protected string $contents;

    /**
     * @var string $canonicalUrl
     */
    protected string $canonicalUrl;

    /**
     * @var array $tags
     */
    protected array $tags;

    /**
     * @var string $pulishStatus
     */
    protected string $pulishStatus = 'public';

    /**
     * Get $title
     *
     * @return  string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set $title
     *
     * @param  string  $title  $title
     *
     * @return  $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get $contents
     *
     * @return  string
     */
    public function getContents(): string
    {
        $contetns = preg_replace('/\r|\n|/', '', $this->contents);
        $contetns = str_replace('\\n', '', $contetns);

        return $contetns;
    }

    /**
     * Set $contents
     *
     * @param  string  $contents  $contents
     *
     * @return  $this
     */
    public function setContents(string $contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get $contentFormat
     *
     * @return  string
     */
    public function getContentFormat(): string
    {
        return $this->contentFormat;
    }

    /**
     * Set $contentFormat
     *
     * @param  string  $contentFormat  $contentFormat
     *
     * @return  $this
     */
    public function setContentFormat(string $contentFormat = 'html')
    {
        if ($contentFormat == 'html' || $contentFormat == 'markdown') {
            $this->contentFormat = $contentFormat;
        }

        return $this;
    }

    /**
     * Get $pulishStatus
     *
     * @return  string
     */
    public function getPulishStatus(): string
    {
        return $this->pulishStatus;
    }

    /**
     * Set $pulishStatus
     *
     * @param  string $pulishStatus
     *
     * @return  $this
     */
    public function setPulishStatus(string $pulishStatus = 'public')
    {
        if ($pulishStatus == 'public' || $pulishStatus == 'draft' || $pulishStatus == 'unlisted') {
            $this->pulishStatus = $pulishStatus;
        }

        return $this;
    }

    /**
     * Get $canonicalUrl
     *
     * @return  string|null
     */
    public function getCanonicalUrl(): ?string
    {
        return $this->canonicalUrl;
    }

    /**
     * Set $canonicalUrl
     *
     * @param  string|null $canonicalUrl
     *
     * @return  $this
     */
    public function setCanonicalUrl(?string $canonicalUrl)
    {
        $this->canonicalUrl = $canonicalUrl;

        return $this;
    }

    /**
     * Get $tags
     *
     * @return  array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * Set $tags
     *
     * @param  array|null  $tags
     *
     * @return  $this
     */
    public function setTags(?array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    public function toArray(bool $allowNull = false): ?array
    {
        $toArray = parent::toArray($allowNull);

        return ArrController::camelFromArray($toArray);
    }
}

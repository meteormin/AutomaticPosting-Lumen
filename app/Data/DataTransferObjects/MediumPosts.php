<?php

namespace App\Data\DataTransferObjects;

use App\Data\Abstracts\Dto;
use App\Data\Utils\ArrController;

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
     * @var string $content
     */
    protected string $content;

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
//    production
    protected string $publishStatus = 'public';
//   test
//    protected string $publishStatus = 'draft';

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
     * @param string $title $title
     *
     * @return  $this
     */
    public function setTitle(string $title): MediumPosts
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return MediumPosts
     */
    public function setContent(string $content): MediumPosts
    {
        $this->content = $content;
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
     * @param string $contentFormat $contentFormat
     *
     * @return  $this
     */
    public function setContentFormat(string $contentFormat = 'html'): MediumPosts
    {
        if ($contentFormat == 'html' || $contentFormat == 'markdown') {
            $this->contentFormat = $contentFormat;
        }

        return $this;
    }

    /**
     * Get $publishStatus
     *
     * @return  string
     */
    public function getPublishStatus(): string
    {
        return $this->publishStatus;
    }

    /**
     * Set $pulishStatus
     *
     * @param string $publishStatus
     *
     * @return  $this
     */
    public function setPublishStatus(string $publishStatus = 'public'): MediumPosts
    {
        if ($publishStatus == 'public' || $publishStatus == 'draft' || $publishStatus == 'unlisted') {
            $this->publishStatus = $publishStatus;
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
     * @param string $canonicalUrl
     *
     * @return  $this
     */
    public function setCanonicalUrl(string $canonicalUrl): MediumPosts
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
     * @param array $tags
     *
     * @return  $this
     */
    public function setTags(array $tags = []): MediumPosts
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

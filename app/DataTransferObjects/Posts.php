<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Abstracts\Dto;

class Posts extends Dto
{
    /**
     * @var int $id
     */
    protected int $id;

    /**
     * @var int $userId
     */
    protected int $userId;

    /**
     * @var string $title
     */
    protected string $title;

    /**
     * @var string $subTitle;
     */
    protected string $subTitle;

    /**
     * @var string $contents
     */
    protected string $contents;

    /**
     * @var string $createdBy
     */
    protected string $createdBy;

    /**
     * @var string $createdAt
     */
    protected string $createdAt;

    /**
     * Get $id
     *
     * @return  int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set $id
     *
     * @param  int  $id  $id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

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
     * @return  self
     */
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get $subTitle;
     *
     * @return  string
     */
    public function getSubTitle(): string
    {
        return $this->subTitle;
    }

    /**
     * Set $subTitle;
     *
     * @param  string  $subTitle  $subTitle;
     *
     * @return  self
     */
    public function setSubTitle(string $subTitle)
    {
        $this->subTitle = $subTitle;

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
     * @return  self
     */
    public function setContents(string $contents)
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get $createdBy
     *
     * @return  string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set $createdBy
     *
     * @param  string  $createdBy  $createdBy
     *
     * @return  self
     */
    public function setCreatedBy(string $createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get $createdAt
     *
     * @return  string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set $createdAt
     *
     * @param  string  $createdAt  $createdAt
     *
     * @return  self
     */
    public function setCreatedAt(string $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get $userId
     *
     * @return  int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set $userId
     *
     * @param  int  $userId  $userId
     *
     * @return  self
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }
}

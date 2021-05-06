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
     * @var string $type
     */
    protected string $type;

    /**
     * @var string $code
     */
    protected string $code;

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
     * @return  $this
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
     * @return  $this
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
     * @return  $this
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
     * @return  $this
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
     * @return  $this
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
     * @return  $this
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
     * @return  $this
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get $type
     * @param string|null $lang en,ko (default is en)
     * @return  string
     */
    public function getType(?string $lang = 'en'): string
    {
        if ($lang == 'ko') {
            return __("stock.{$this->type}");
        }

        return $this->type;
    }

    /**
     * Set $type
     *
     * @param  string  $type
     *
     * @return  $this
     */
    public function setType(string $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get $code
     * @param string $type return data type code or ko (default is code)
     * @return  string
     */
    public function getCode(string $type = 'code')
    {
        if ($type == 'ko') {
            if ($this->type == 'sector') {
                return config("sectors.kospi.sectors_raw.{$this->code}");
            }

            if ($this->type == 'theme') {
                $theme = collect(config('themes'))->filter(function ($item) {
                    return $item['code'] == $this->code;
                })->first();

                return str_replace('_', ' ', $theme['name']);
            }
        }

        return $this->code;
    }

    /**
     * Set $code
     *
     * @param  string  $code  $code
     *
     * @return  self
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }
}

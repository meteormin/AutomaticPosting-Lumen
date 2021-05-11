<?php

namespace App\Data\DataTransferObjects;

use App\Data\Abstracts\Dto;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;

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
     * @var bool $published
     */
    protected bool $published;

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
    public function setId(int $id): Posts
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
    public function setTitle(string $title): Posts
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
    public function setSubTitle(string $subTitle): Posts
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
    public function setContents(string $contents): Posts
    {
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get $createdBy
     *
     * @return  string
     */
    public function getCreatedBy(): string
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
    public function setCreatedBy(string $createdBy): Posts
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get $createdAt
     *
     * @return  string
     */
    public function getCreatedAt(): string
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
    public function setCreatedAt(string $createdAt): Posts
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
    public function setUserId(int $userId): Posts
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
    public function setType(string $type): Posts
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get $code
     * @param string $type return data type code or ko (default is code)
     * @return  string
     */
    public function getCode(string $type = 'code'): string
    {
        if ($type == 'ko') {
            if ($this->type == 'sector') {
                return config("sectors.kospi.sectors_raw.{$this->code}");
            }

            if ($this->type == 'theme') {
                $name = config("themes.kospi.themes_raw.{$this->code}");

                return str_replace('_', ' ', $name);
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
    public function setCode(string $code): Posts
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of published
     */
    public function getPublished(): bool
    {
        return $this->published;
    }

    /**
     * Set the value of published
     * @param bool $published
     * @return  $this
     */
    public function setPublished(bool $published): Posts
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return string|null
     * @throws FileNotFoundException
     */
    public function getContentImg(): ?string
    {
        if(is_null($this->id)){
            return null;
        }

        $filename="posts/{$this->id}.png";

        if(Storage::disk('local')->exists($filename)){
            return Storage::disk('local')->get($filename);
        }

        $filePath = storage_path("app/$filename");
        exec("wkhtmltoimage http://localhost:58080/api/posts/{$this->id} {$filePath}",$output,$code);

        if($code === 0){
            return $this->getContentImg();
        }

        return json_encode($output);
    }
}

<?php


namespace App\Data\DataTransferObjects;


use Miniyus\Mapper\Data\Dto;
use JsonMapper_Exception;

class WPosts extends Dto
{
    private string $status = 'publish';
    private string $title;
    private string $content;
    private int $author = 1;
    private int $categories = 1;
    private string $commentStatus = 'open';
    private string $pingStatus = 'open';
    private string $altText = '';
    private string $caption = '';
    private string $description = '';

    /**
     * WPosts constructor.
     * @param array|null $params
     * @throws JsonMapper_Exception
     */
    public function __construct(array $params = null)
    {
        parent::__construct($params);
    }


    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getAuthor(): int
    {
        return $this->author;
    }

    /**
     * @param int $author
     */
    public function setAuthor(int $author): void
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getCategories(): int
    {
        return $this->categories;
    }

    /**
     * @param int $categories
     */
    public function setCategories(int $categories): void
    {
        $this->categories = $categories;
    }
}

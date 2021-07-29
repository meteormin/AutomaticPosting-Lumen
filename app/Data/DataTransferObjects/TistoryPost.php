<?php


namespace App\Data\DataTransferObjects;


class TistoryPost extends \Miniyus\Mapper\Data\Dto
{
    protected ?int $postId = null;
    protected string $title;
    protected string $content;
    protected int $visibility = 3;
    protected int $category;
    protected string $published;
    protected string $sloan;
    protected string $tag;
    protected int $acceptComment = 1;

    /**
     * @return int
     */
    public function getPostId(): int
    {
        return $this->postId;
    }

    /**
     * @param int $postId
     * @return TistoryPost
     */
    public function setPostId(int $postId): TistoryPost
    {
        $this->postId = $postId;
        return $this;
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
     * @return TistoryPost
     */
    public function setTitle(string $title): TistoryPost
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
     * @return TistoryPost
     */
    public function setContent(string $content): TistoryPost
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return int
     */
    public function getVisibility(): int
    {
        return $this->visibility;
    }

    /**
     * @param int $visibility
     * @return TistoryPost
     */
    public function setVisibility(int $visibility): TistoryPost
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     * @return TistoryPost
     */
    public function setCategory(int $category): TistoryPost
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getPublished(): string
    {
        return $this->published;
    }

    /**
     * @param string $published
     * @return TistoryPost
     */
    public function setPublished(string $published): TistoryPost
    {
        $this->published = $published;
        return $this;
    }

    /**
     * @return string
     */
    public function getSloan(): string
    {
        return $this->sloan;
    }

    /**
     * @param string $sloan
     * @return TistoryPost
     */
    public function setSloan(string $sloan): TistoryPost
    {
        $this->sloan = $sloan;
        return $this;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return TistoryPost
     */
    public function setTag(string $tag): TistoryPost
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return int
     */
    public function getAcceptComment(): int
    {
        return $this->acceptComment;
    }

    /**
     * @param int $acceptComment
     * @return TistoryPost
     */
    public function setAcceptComment(int $acceptComment): TistoryPost
    {
        $this->acceptComment = $acceptComment;
        return $this;
    }
}

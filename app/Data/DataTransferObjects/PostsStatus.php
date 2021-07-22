<?php

namespace App\Data\DataTransferObjects;

use Miniyus\Mapper\Data\Dto;

class PostsStatus extends Dto
{
    /**
     * @var string
     */
    protected string $type;

    /**
     * @var int
     */
    protected int $typeCount;

    /**
     * @var string
     */
    protected string $code;

    /**
     * @var int
     */
    protected int $codeCount;

    /**
     * Get the value of type
     *
     * @return  string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the value of type
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
     * Get the value of typeCount
     *
     * @return  int
     */
    public function getTypeCount(): int
    {
        return $this->typeCount;
    }

    /**
     * Set the value of typeCount
     *
     * @param  int  $typeCount
     *
     * @return  $this
     */
    public function setTypeCount(int $typeCount)
    {
        $this->typeCount = $typeCount;

        return $this;
    }

    /**
     * Get the value of code
     *
     * @return  string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @param  string  $code
     *
     * @return  $this
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of codeCount
     *
     * @return  int
     */
    public function getCodeCount(): int
    {
        return $this->codeCount;
    }

    /**
     * Set the value of codeCount
     *
     * @param  int  $codeCount
     *
     * @return  $this
     */
    public function setCodeCount(int $codeCount)
    {
        $this->codeCount = $codeCount;

        return $this;
    }
}

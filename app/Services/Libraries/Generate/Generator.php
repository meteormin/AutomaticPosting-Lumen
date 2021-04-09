<?php

namespace App\Services\Libraries\generate;

abstract class Generator
{

    protected $name;

    /**
     * json
     *
     * @var string|null
     */
    protected $json;

    /**
     * template
     *
     * @var \App\Libraries\Generate\Template
     */
    protected $template;

    /**
     *
     *
     * @var \App\Libraries\Generate\MakeClass
     */
    protected $maker;

    public function __construct(string $name, string $json)
    {
        $this->name = $name;
        $this->json = $json;
        $this->maker = new MakeClass();
    }

    /**
     * 실행
     * 상황에 맞게 구현
     */
    abstract public function generate();

    /**
     * get class name
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * get origin json
     *
     * @return string|null
     */
    public function getJson(): ?string
    {
        return $this->json;
    }

    /**
     * get template
     *
     * @return \App\Libraries\Generate\Template|null
     */
    public function getTemplate(): ?\App\Libraries\Generate\Template
    {
        return $this->template;
    }
}

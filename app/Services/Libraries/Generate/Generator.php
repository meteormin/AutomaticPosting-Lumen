<?php

namespace App\Services\Libraries\Generate;

abstract class Generator
{

    /**
     * @var string
     */
    protected string $name;

    /**
     * json
     *
     * @var string|null
     */
    protected ?string $json = null;

    /**
     * template
     *
     * @var Template
     */
    protected Template $template;

    /**
     *
     *
     * @var MakeClass
     */
    protected MakeClass $maker;

    /**
     * Generator constructor.
     * @param string $name
     * @param string|null $json
     */
    public function __construct(string $name, string $json = null)
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
     * @return Template|null
     */
    public function getTemplate(): ?Template
    {
        return $this->template;
    }
}

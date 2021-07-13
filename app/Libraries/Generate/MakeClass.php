<?php

namespace App\Libraries\Generate;

class MakeClass extends Maker
{
    /**
     * 클래스가 생성될 경로
     * @var string
     */
    protected string $path;
    /**
     * stub 파일 경로
     * @var string
     */
    protected string $stubPath;

    /**
     * 새로 생성할 파일의 확장자
     *
     * @var string
     */
    protected string $ext;

    public function __construct(string $path = null, string $ext = 'php')
    {
        parent::__construct($path,$ext);

        $this->stubPath = base_path(config('makeclass.stub_path', 'app/Stubs'));
        $this->path = base_path(config('makeclass.save_path', 'app'));
        $this->ext = $ext;
        if (!is_null($path)) {
            $this->setPath($path);
        }
    }
}

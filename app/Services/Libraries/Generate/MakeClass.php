<?php

namespace App\Services\Libraries\Generate;

class MakeClass extends Maker
{
    /**
     * 클래스가 생성될 경로
     * @var string
     */
    protected $path;
    /**
     * stub 파일 경로
     * @var string
     */
    protected $stubPath;

    /**
     * 새로 생성할 파일의 확장자
     *
     * @var string
     */
    protected $ext;

    public function __construct(string $path = null, string $ext = 'php')
    {
        $this->stubPath = base_path(config('make_class.stub_path', 'app/Stubs'));
        $this->path = base_path(config('make_class.save_path', 'app'));
        $this->ext = $ext;
        if (!is_null($path)) {
            $this->setPath($path);
        }
    }
}

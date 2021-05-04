<?php

namespace App\Services\Libraries\Generate;

use App\Services\Libraries\Generate\Generator;

class TableGenerator extends Generator
{
    /**
     * @var string
     */
    protected string $title;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $date;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected array $datas;

    public function __construct(string $title, string $name, string $date, array $datas)
    {
        $this->maker = new MakeClass();
        $this->datas = $datas;
        $this->title = $title;
        $this->name = $name;
        $this->date = $date;
    }

    public function generate()
    {
        $body = '';
        foreach ($this->datas as $data) {
            $body .= $this->maker->run('tbody', $data) . '\\n';
        }

        return $this->maker->run('table', ['title' => $this->title, 'name' => $this->name, 'date' => $this->date, 'body' => $body]);
    }
}

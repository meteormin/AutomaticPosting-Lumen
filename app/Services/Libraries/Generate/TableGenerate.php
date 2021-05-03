<?php

namespace App\Services\Libraries\Generate;

use App\Services\Libraries\Generate\Generator;

class TableGenerator extends Generator
{
    protected $title;
    protected $name;
    protected $date;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $parameters;

    public function __construct(string $title, string $name, string $date, array $parameters)
    {
        $this->maker = new MakeClass();
        $this->parameters = $parameters;
        $this->title = $title;
        $this->name = $name;
        $this->date = $date;
    }

    public function generate()
    {
        $body = '';
        foreach ($this->parameters as $parameter) {
            $body .= $this->maker->run('tbody', $parameter) . '\\n';
        }

        return $this->maker->run('table', ['title' => $this->title, 'name' => $this->name, 'date' => $this->date, 'body' => $body]);
    }
}

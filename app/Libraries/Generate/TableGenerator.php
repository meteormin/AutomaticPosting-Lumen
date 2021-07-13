<?php

namespace App\Libraries\Generate;

use App\Libraries\Generate\Generator;

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
    protected array $data;

    /**
     * TableGenerator constructor.
     * @param string $title
     * @param string $name
     * @param string $date
     * @param array $data
     */
    public function __construct(string $title, string $name, string $date, array $data)
    {
        parent::__construct($name);
        $this->maker = new MakeClass();
        $this->data = $data;
        $this->title = $title;
        $this->name = $name;
        $this->date = $date;
    }

    public function generate(): ?string
    {
        $body = '';
        foreach ($this->data as $data) {
            $body .= $this->maker->run('tbody', $data) . '\\n';
        }

        $header = $this->makeHeader();

        return $this->maker->run('table', [
            'title' => $this->title,
            'name' => $this->name,
            'date' => $this->date,
            'thead_class' => implode(' ', config('maketable.thead.class')),
            'header' => $header,
            'body' => $body
        ]);
    }

    public function makeHeader(): string
    {
        $th = config('maketable.thead.th');

        $class = implode(' ', $th['class']);
        $text = $th['text'];
        $header = '';
        foreach ($text as $txt) {
            $header .= $this->maker->run('thead', ['class' => $class, 'text' => $txt]) . '\\n';
        }

        return $header;
    }
}

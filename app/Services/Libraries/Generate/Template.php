<?php

namespace App\Libraries\Generate;

use JsonMapper;

abstract class Template
{
    /**
     *
     *
     * @param   Object  $data  [$data description]
     *
     * @return  $this        [return description]
     */
    public function map(Object $data)
    {
        return (new JsonMapper)->map($data, $this);
    }
}

<?php

namespace App\Services\OpenDart;

use App\Models\OpenDart;
use App\Services\Service;

class OpenDartService extends Service
{
    /**
     * @var Model
     */
    protected $model;

    protected $module;

    public function __construct()
    {
        $this->model = new OpenDart();
        $this->module = new OpenDartClient();
    }

    public function getSingle()
    {
    }

    public function getMultiple()
    {
    }
}

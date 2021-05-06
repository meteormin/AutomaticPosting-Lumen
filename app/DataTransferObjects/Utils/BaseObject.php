<?php

namespace App\DataTransferObjects\Utils;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

abstract class BaseObject implements Arrayable, Jsonable
{
    use Transformation;
}

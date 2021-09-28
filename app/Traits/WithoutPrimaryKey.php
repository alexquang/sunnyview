<?php

namespace App\Traits;

trait WithoutPrimaryKey
{
    protected $primaryKey = null;

    public $incrementing = false;
}

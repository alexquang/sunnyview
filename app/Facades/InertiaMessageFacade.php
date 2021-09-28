<?php

namespace App\Facades;

use App\Helpers\InertiaMessage;
use Illuminate\Support\Facades\Facade;

class InertiaMessageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return InertiaMessage::class;
    }
}

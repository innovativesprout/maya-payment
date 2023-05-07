<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaClient extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-client';
    }
}


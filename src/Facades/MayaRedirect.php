<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaRedirect extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-redirect';
    }
}


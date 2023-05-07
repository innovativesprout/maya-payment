<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaBuyer extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-buyer';
    }
}


<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaItem extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-item';
    }
}


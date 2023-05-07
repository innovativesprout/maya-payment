<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaTotalAmount extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-total-amount';
    }
}


<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaCheckout extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-checkout';
    }
}


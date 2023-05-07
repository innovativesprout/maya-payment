<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaShippingAddress extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-shipping-address';
    }
}


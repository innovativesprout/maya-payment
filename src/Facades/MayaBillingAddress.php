<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaBillingAddress extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-billing-address';
    }
}


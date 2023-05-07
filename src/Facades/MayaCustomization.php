<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaCustomization extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-customization';
    }
}


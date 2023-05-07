<?php namespace Innovativesprouts\MayaPayment\Facades;

use Illuminate\Support\Facades\Facade;

class MayaWebhook extends Facade {
    protected static function getFacadeAccessor(): string
    {
        return 'maya-webhook';
    }
}


<?php namespace Innovativesprouts\MayaPayment;

use Illuminate\Support\ServiceProvider;
use Innovativesprouts\MayaPayment\Services\BillingAddress;
use Innovativesprouts\MayaPayment\Services\Buyer;
use Innovativesprouts\MayaPayment\Services\Item;
use Innovativesprouts\MayaPayment\Services\MayaCheckout;
use Innovativesprouts\MayaPayment\Services\MayaClient;
use Innovativesprouts\MayaPayment\Services\Redirect;
use Innovativesprouts\MayaPayment\Services\ShippingAddress;
use Innovativesprouts\MayaPayment\Services\TotalAmount;
use Innovativesprouts\MayaPayment\Services\Webhook;

class MayaPaymentServiceProvider extends ServiceProvider{

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/maya.php' => config_path('maya.php'),
        ], 'config-maya');
    }

    public function register()
    {
        $this->app->bind('maya-client', function(){
            return new MayaClient;
        });

        $this->app->bind('maya-checkout', function(){
            return new MayaCheckout;
        });

        $this->app->bind('maya-item', function(){
            return new Item;
        });

        $this->app->bind('maya-webhook', function(){
            return new Webhook;
        });

        $this->app->bind('maya-total-amount', function(){
            return new TotalAmount;
        });

        $this->app->bind('maya-shipping-address', function(){
            return new ShippingAddress;
        });

        $this->app->bind('maya-billing-address', function(){
            return new BillingAddress;
        });

        $this->app->bind('maya-buyer', function(){
            return new Buyer;
        });

        $this->app->bind('maya-redirect', function(){
            return new Redirect;
        });

    }
}

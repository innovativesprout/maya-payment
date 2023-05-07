<?php namespace Innovativesprouts\MayaPayment\Services;


class MayaCheckout{

    public function checkout($parameters = [])
    {
        return \Innovativesprouts\MayaPayment\Facades\MayaClient::setRequestMethod('POST')->setService('checkout')->send($parameters);
    }
}

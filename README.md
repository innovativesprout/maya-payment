<br/>
<p align="center">
  <a href="https://github.com/innovativesprout/maya-payment">
    <img src="https://github.com/innovativesprout/maya-payment/blob/master/MayaLaravelPackage.png" alt="Logo">
  </a>
</p>

<h3 align="center">Maya Online Payment API</h3>

<p align="center">
    Laravel Package that will handle the Maya Payments / Checkout
    <br/>
    <br/>
    <a href="https://github.com/innovativesprout/maya-payment/issues">Request Feature</a>
</p>

![Downloads](https://img.shields.io/github/downloads/innovativesprout/maya-payment/v1.1.0/total) ![Contributors](https://img.shields.io/github/contributors/innovativesprout/maya-payment?color=dark-green) ![Issues](https://img.shields.io/github/issues/innovativesprout/maya-payment) ![License](https://img.shields.io/github/license/innovativesprout/maya-payment)

## Table Of Contents

* [What It Does](#what-it-does)
* [Getting Started](#getting-started)
    * [Installation](#installation)
* [Usage](#usage)
    * [Adding An Item](#adding-an-item)
    * [Customer Shipping](#customer-shipping-address)
    * [Customer Billing](#customer-billing-address)
    * [Buyer Details](#buyers-details)
    * [Redirect URLs](#redirect-urls)
    * [Checkout](#checkout)
    * [Webhook Management](#webhooks-management)
        * [Get All Webhook](#get-all-webhooks)
        * [Create New Webhook](#create-new-webhook)
        * [Get Webhook](#get-webhook)
        * [Update Webhook](#update-webhook)
        * [Delete Webhook](#delete-webhook)
    * [Customizations](#customizations)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
    * [Etiquette](#etiquette)
    * [Viability](#viability)
    * [Procedure](#procedure)
* [Credits](#credits)
* [License](#license)

## What It Does

This package enables you to handle customer checkouts, webhooks, and other payment-related tasks utilizing the Maya API.

#### Supported Features:

- Checkout
- Webhooks
- Customizations

#### Next Features:

- Payment Transactions
- Card Payment Vault
- Wallet
- QR

## Getting Started

This is how you can install or use the library.

### Installation

1. Install Maya Payment to your Laravel Application

```bash
  composer require innovativesprout/maya-payment
```

2. Publish the configuration

```bash
  php artisan vendor:publish --tag=config-maya
```

3. In your `config/maya.php`, add your `public_key` and `private_key` from your PayMaya account.
#### config/maya.php
```php
return [
  "public_key" => "{YOUR_MAYA_PUBLIC_KEY}",
  "private_key" => "{YOUR_MAYA_PRIVATE_KEY}",

   // other configurations...
];
```

## Usage
Integrate to your Laravel Application.

### Adding an Item

```php
use \Innovativesprouts\MayaPayment\Facades\MayaItem;

MayaItem::addItem([
    "amount" => [
        "value" => 1200
    ],
    "totalAmount" => [
        "value" => 1200
    ],
    "name" => "Shoes",
    "code" => "SHOE-1",
    "description" => "Nike Shoes",
    "quantity" => "1"
]);

```

### Calculating the total amount, discounts, shipping fee and other charges

```php
use Innovativesprouts\MayaPayment\Facades\MayaTotalAmount;
```

You need to pass the `MayaItem::getItems()` to calculate the total amount.

```php
MayaTotalAmount::setItems(MayaItem::getItems());
MayaTotalAmount::setDiscount("0.05");
MayaTotalAmount::setCurrency("PHP");
MayaTotalAmount::setServiceCharge("100");
MayaTotalAmount::setShippingFee("250");
MayaTotalAmount::setTax("100");
```

or

```php
MayaTotalAmount::setItems(MayaItem::getItems())
->setDiscount("0.05")
->setCurrency("PHP")
->setServiceCharge("100")
->setShippingFee("250")
->setTax("100");
```

To get the totalAmount object you can call the `get()` method:
```php
return MayaTotalAmount::get();
```

Result:
```php
[
    "currency" => "PHP",
    "value" => 1649.95, // float
    "details" => [
        "discount" => "0.05",
        "serviceCharge" => "100",
        "shippingFee" => "250",
        "tax" => "100",
        "subtotal" => "1200"
    ]
];
```

### Customer Shipping Address

```php
use Innovativesprouts\MayaPayment\Facades\MayaShippingAddress;

ShippingAddress::setFirstName('Test First Name')
    ->setLastName('Test Last Name')
    ->setPhone('+63912345678')
    ->setEmail('client@innovativesprout.com')
    ->setCity('Test City')
    ->setLine1('Test Line 1')
    ->setLine2('Test Line 2')
    ->setState('Test State')
    ->setZipCode("2222")
    ->setCountryCode("PH");
```


### Customer Billing Address

```php
use Innovativesprouts\MayaPayment\Facades\MayaBillingAddress;

MayaBillingAddress::setLine1('Test Line 1');
MayaBillingAddress::setLine2('Test Line  2');
MayaBillingAddress::setCity('Test City');
MayaBillingAddress::setState('Test State');
MayaBillingAddress::setZipCode("2222");
MayaBillingAddress::setCountryCode("PH");
```

### Buyer's Details

```php
use Innovativesprouts\MayaPayment\Facades\MayaBuyer;

MayaBuyer::setFirstName('Jerson')
    ->setLastName('Ramos')
    ->setEmail('jerson@innovativesprout.com')
    ->setPhone('+639052537600');
```

To add shipping / billing address to the buyer, you can use this:

#### For shipping address:
```php
MayaBuyer::setShippingAddress(MayaShippingAddress::get());
```

#### For billing address:
```php
MayaBuyer::setBillingAddress(MayaBillingAddress::get());
```

### Redirect URLs

You can use route name from your `web.php` or `api.php` file or use static URL with parameters.

The `$custom_uuid` is from your order's table or any reference ID from your application.

```php
use Innovativesprouts\MayaPayment\Facades\MayaRedirect;

MayaRedirect::setCancel(route('checkout.cancel') . '?id=' . $custom_uuid);
MayaRedirect::setFailure(route('checkout.failure') . '?id=' . $custom_uuid);
MayaRedirect::setSuccess(route('checkout.success') . '?id=' . $custom_uuid);
```

### Checkout

Build body request for your checkout based on our created objects above.

```php

$parameters = [
    "totalAmount" => MayaTotalAmount::get(),
    "items" => MayaItem::getItems(),
    "buyer" => MayaBuyer::get(),
    "redirectUrl" => MayaRedirect::getRedirectUrls(),
    "requestReferenceNumber" => $custom_uuid
];

$response = MayaCheckout::checkout($parameters);
return response()->json($response);

```

#### Response from Maya Checkout Request:
```json
{
    "checkoutId": "{CHECKOUT_ID}",
    "redirectUrl": "https://payments.maya.ph/v2/checkout?id={CHECKOUT_ID}"
}
```

## Webhooks Management

Use the `MayaWebhook` by injecting the facade to your application and to be able to manage your webhooks.

```php
use Innovativesprouts\MayaPayment\Facades\MayaWebhook;;
```

### Get All Webhooks
```php
return MayaWebhook::get();
```
#### Response:
```json
[
    {
        "id": "7549dd53-38fb-49b9-9ad8-af6223937e92",
        "name": "PAYMENT_FAILED",
        "callbackUrl": "https://store-philippines.worldcup.basketball?wc-api=cynder_paymaya_payment",
        "createdAt": "2023-04-24T06:57:35.000Z",
        "updatedAt": "2023-04-24T06:57:35.000Z"
    },
    {
        "id": "e63c832b-e9dc-426e-831f-6756bbd33bbc",
        "name": "PAYMENT_EXPIRED",
        "callbackUrl": "https://store-philippines.worldcup.basketball?wc-api=cynder_paymaya_payment",
        "createdAt": "2023-04-24T06:57:30.000Z",
        "updatedAt": "2023-04-24T06:57:30.000Z"
    }
]
```

### Create New Webhook

The supported events that you can pass through `for` method are the following: <br>

`AUTHORIZED`,`PAYMENT_SUCCESS`,`PAYMENT_FAILED`,`PAYMENT_EXPIRED`,`PAYMENT_CANCELLED`,`3DS_PAYMENT_SUCCESS`,`3DS_PAYMENT_FAILURE`,`3DS_PAYMENT_DROPOUT`,`RECURRING_PAYMENT_SUCCESS`,`RECURRING_PAYMENT_FAILURE`,`CHECKOUT_SUCCESS`,`CHECKOUT_FAILURE`,`CHECKOUT_DROPOUT`,`CHECKOUT_CANCELLED`

Pass the `URL` parameter on `create()` method.

```php
return MayaWebhook::for("PAYMENT_SUCCESS")->create('http://www.merchantsite.com/success');
```

#### Response:
```json
{
    "id": "98397531-e6cd-4c5c-ba6c-089546098989",
    "name": "PAYMENT_SUCCESS",
    "callbackUrl": "http://www.merchantsite.com/success",
    "createdAt": "2023-05-07T05:28:27.000Z",
    "updatedAt": "2023-05-07T05:28:27.000Z"
}
```

### Get Webhook

Pass the ID of the webhook

```php
return MayaWebhook::getById('98397531-e6cd-4c5c-ba6c-089546098989');
```

#### Response:
```json
{
    "id": "98397531-e6cd-4c5c-ba6c-089546098989",
    "name": "PAYMENT_SUCCESS",
    "callbackUrl": "http://www.merchantsite.com/success",
    "createdAt": "2023-05-07T05:28:27.000Z",
    "updatedAt": "2023-05-07T05:28:27.000Z"
}
```

### Update Webhook

Pass the ID of the webhook that you want update and the new `URL`. The `first` parameter will be the ID of the webhook and the `second` parameter will be the new `URL`.


```php
return MayaWebhook::update('98397531-e6cd-4c5c-ba6c-089546098989', 'http://www.merchantsite.com/success'); 
```

#### Response:
```json
{
    "id": "98397531-e6cd-4c5c-ba6c-089546098989",
    "name": "PAYMENT_SUCCESS",
    "callbackUrl": "http://www.merchantsite.com/success",
    "createdAt": "2023-05-07T05:28:27.000Z",
    "updatedAt": "2023-05-07T05:44:36.000Z"
}
```

### Delete Webhook

Pass the ID of the webhook that you want to delete.

```php
return MayaWebhook::delete('98397531-e6cd-4c5c-ba6c-089546098989'); 
```

#### Response:
```json
{
    "id": "98397531-e6cd-4c5c-ba6c-089546098989",
    "name": "PAYMENT_SUCCESS",
    "callbackUrl": "http://www.merchantsite.com/success",
    "createdAt": "2023-05-07T05:28:27.000Z",
    "updatedAt": "2023-05-07T05:44:36.000Z"
}
```
## Customizations

Use the `MayaCustomization` by injecting the facade to your application.

```php
use Innovativesprouts\MayaPayment\Facades\MayaCustomization;
```

### Set Customization

Set your `LogoUrl`, `IconUrl`, `AppleTouchIconUrl`, `CustomTitle` and `ColorScheme`. These are the required fields.

#### Helper functions:

- `hideReceipt()` or `showReceipt()` - Indicates if the merchant does not allow its payers to freely send transaction receipts.
- `skipResultPage()` or `doNotSkipResultPage()` - Indicates if the merchant does not want to show the payment result page.
  When skipped, the payment page redirects immediately to the merchant's redirect URL. 
- `showMerchantName()` or `hideMerchantName()` - Indicates if the merchant name on the result page is displayed.

```php
return MayaCustomization::setLogoUrl("https://www.merchantsite.com/icon-store.b575c975.svg")
        ->setIconUrl("https://www.merchantsite.com/favicon.ico")
        ->setAppleTouchIconUrl("https://www.merchantsite.com/touch-icon-ipad-retina.png")
        ->setCustomTitle("Merchant Store")
        ->setColorScheme("#85c133")
        ->showReceipt()
        ->skipResultPage()
        ->showMerchantName()
        ->setRedirectTimer(10)
        ->set();
```

#### Response:
```json
{
    "logoUrl": "https://www.merchantsite.com/icon-store.b575c975.svg",
    "iconUrl": "https://www.merchantsite.com/favicon.ico",
    "appleTouchIconUrl": "https://www.merchantsite.com/touch-icon-ipad-retina.png",
    "customTitle": "Merchant Store",
    "colorScheme": "#85c133",
    "redirectTimer": 10,
    "hideReceiptInput": false,
    "skipResultPage": true,
    "showMerchantName": true
}
```

### Get Customization

```php
return MayaCustomization::get();
```

#### Response:
```json
{
    "logoUrl": "https://www.merchantsite.com/icon-store.b575c975.svg",
    "iconUrl": "https://www.merchantsite.com/favicon.ico",
    "appleTouchIconUrl": "https://www.merchantsite.com/touch-icon-ipad-retina.png",
    "customTitle": "Merchant Store",
    "colorScheme": "#85c133",
    "redirectTimer": 10,
    "hideReceiptInput": false,
    "skipResultPage": true,
    "showMerchantName": true
}
```

### Delete Customization

```php
return MayaCustomization::delete();
```

#### Response:
```php
// Blank Response
```

## Roadmap

See the [open issues](https://github.com/innovativesprout/maya-payment/issues) for a list of proposed features (and known issues).

## Contributing

Contributions are welcome and will be fully credited.

Please read and understand the contribution guide before creating an issue or pull request.

### Etiquette
This project is open source, and as such, the maintainers give their free time to build and maintain the source code
held within. They make the code freely available in the hope that it will be of use to other developers. It would be
extremely unfair for them to suffer abuse or anger for their hard work.

Please be considerate towards maintainers when raising issues or presenting pull requests. Let's show the
world that developers are civilized and selfless people.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient
quality to benefit the project. Many developers have different skillsets, strengths, and weaknesses. Respect the maintainer's decision, and do not be upset or abusive if your submission is not used.

### Viability

When requesting or submitting new features, first consider whether it might be useful to others. Open
source projects are used by many developers, who may have entirely different needs to your own. Think about
whether or not your feature is likely to be used by other users of the project.

### Procedure

Before filing an issue:

- Attempt to replicate the problem, to ensure that it wasn't a coincidental incident.
- Check to make sure your feature suggestion isn't already present within the project.
- Check the pull requests tab to ensure that the bug doesn't have a fix in progress.
- Check the pull requests tab to ensure that the feature isn't already in progress.

Before submitting a pull request:
- Check the codebase to ensure that your feature doesn't already exist.
- Check the pull requests to ensure that another person hasn't already submitted the feature or fix.

## Credits

- [Maya](https://developers.maya.ph/docs)
- [All Contributors](../../contributors)

## License

Distributed under the MIT License. See [LICENSE](https://github.com/innovativesprout/maya-payment/blob/master/LICENSE.md) for more information.




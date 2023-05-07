<?php

return [
    "environment" => "production",
    "api_url" => "https://pg.maya.ph",
    "web_url" => "https://payments.maya.ph",
    "public_key" => "",
    "private_key" => "",

    "sandbox_api_url" => "https://pg-sandbox.paymaya.com",
    "sandbox_web_url" => "https://payments.maya.ph",

    "sandbox_public_key" => "",
    "sandbox_private_key" => "",

    "services" => [
        "checkout" => [
            "url" => "/checkout/v1/checkouts",
            "auth_type" => "public_key"
        ],
        "webhook" => [
            "url" => "/payments/v1/webhooks",
            "auth_type" => "private_key"
        ],
        "customization" => [
            "url" => "/payments/v1/customizations",
            "auth_type" => "private_key"
        ]
    ]
];

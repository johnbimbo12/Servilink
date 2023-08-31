<?php

/*
 * This file is part of the Laravel Rave package.
 *
 * (c) Oluwole Adebiyi - Flamez <flamekeed@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    'publicKey' => env('VEND_PUBLIC_KEY'),
    'privateKey' => env('VEND_PRIVATE_KEY'),
    'merchantID' => env('VEND_MERCHANT_ID'),
    
    'bani_baseUrl' => env('BANI_BASE_URL'),
    'bani_public_key' => env('BANI_PUBLIC_KEY')
];
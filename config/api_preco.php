<?php

use app\lib\componentes\ApiPreco;

return [
    'class' => ApiPreco::class,
    'apiBitcoin' => 'https://blockchain.info/ticker',
    'apiUsa' => 'https://financialmodelingprep.com/api/v3/quote-short/',
    'apiUsaKey' => ' ',
    'apiBr' => 'https://brapi.dev/api/quote/',
    'apiBrKey' => '',
];

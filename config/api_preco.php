<?php

use app\lib\componentes\ApiPreco;

return [
   'class' => ApiPreco::class,
   'apiBitcoin' => 'https://blockchain.info/ticker',
   'apiUsa' => 'https://financialmodelingprep.com/stable/profile?symbol=',
   'apiUsaKey' => '&apikey=<sua api key>',
   'apiBr' => 'https://brapi.dev/api/quote/',
   'apiBrKey' => '?token=<seu token key>',
   'apiMoeda' => 'https://economia.awesomeapi.com.br/last/USD-BRL',
   'apiMoedaKey' => '?token=<key>'
];

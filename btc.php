<?php

//$content = file_get_contents('http://example.com', false, $context);
//echo file_get_contents('https://coinmarketcap.com/pt-br/exchanges/binance/');

$url = 'https://br.investing.com/crypto/bitcoin/btc-brl';

// Inicializa o cURL
$ch = curl_init();

// Define a URL a ser acessada
curl_setopt($ch, CURLOPT_URL, $url);

// Configura o cURL para retornar o resultado como string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Executa a requisição e obtém a resposta
$response = curl_exec($ch);

// Verifica se ocorreu algum erro durante a requisição
if (curl_errno($ch)) {
    // Manipula o erro de acordo com sua necessidade
    $error_message = curl_error($ch);
    // Exibe ou registra a mensagem de erro
    echo "Erro ao fazer a requisição: $error_message";
}

// Fecha o recurso cURL
curl_close($ch);

// Agora, $response contém o conteúdo da página solicitada
echo $response;

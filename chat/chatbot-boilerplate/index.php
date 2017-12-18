<?php
include("../../include/data.php");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//https://developers.facebook.com/docs/messenger-platform/webhook-reference/message-received
require('parser.php');

// define('BOT_TOKEN', 'EAAR9nHZBpogcBADSfPLSfXPyrNZBKpQetOFTwAEZBjdnTXVqgsHnS7ZCrZBNYFeqMxIwmxpT1bDNe1sjJtALbxtOgDmHojjTlGKh6mcian1t2e7ZCtd1V8Nsd4oL3Vg0DMguwU2V5idqInulJjRQmJB0qtd7aqSwUQm0J2PQc1o8AXFVi38JmR');

define('VERIFY_TOKEN', 'Senha1234');
// define('API_URL', 'https://graph.facebook.com/v2.11/me/messages?access_token='.BOT_TOKEN);
// wfile("".API_URL);

wfile("---------------------------------");
wfile("Requisicao criada");
$hub_verify_token = null;

function processMessage($message) {
	wfile("Processando mensagem");
  // processa a mensagem recebida

  $sender = $message['sender']['id'];
  $text = $message['message']['text'];//texto recebido na mensagem

	wfile("Texto recebido: " . $text);
  if (isset($text)) {
		if ($text == "Ola") {
			sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => 'Olá, tudo bem?')));
		}else{
			sendMessage(array('recipient' => array('id' => $sender), 'message' => array('text' => 'Comando "' . $text. '" nao encotrado')));
		}
  }
}
function sendMessage($parameters) {
	  $options = array(
	  'http' => array(
		'method'  => 'POST',
		'content' => json_encode($parameters),
		'header'=>  "Content-Type: application/json\r\n" .
					"Accept: application/json\r\n"
		)
	);

	$context  = stream_context_create( $options );
	file_get_contents(API_URL, false, $context );
}
//-----VEFICA O WEBHOOK-----//
//wfile("Verificando webhook");
//wfile("WEBHOOK: ".$_REQUEST['hub_challenge']);
if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}
if ($hub_verify_token === VERIFY_TOKEN) {
    echo $challenge;
	//wfile("WEBHOOK Valido");
}else{
	//wfile("WEBHOOK Invalido");
}
//-----FIM VERIFICAÇÃO-----//

$update_response = file_get_contents("php://input");

$update = json_decode($update_response, true);
//$results = print_r($update, true);
//wfile("Response: ".($results));



$pageID = $update['entry'][0]['id'];
wfile("Page ID: ".($pageID));
if($pageID == "720577281466461"){
	define('BOT_TOKEN', 'EAAR9nHZBpogcBAPZA9ly37EHMJ6UxrnNc9xwUY5mkyWm4QdncxSlkIz4wwih4ShShOZCK3A5TM5ZC541dB2Rz39x0tFi9AVpJcnPEDjj0Xkm8Su5Ewqqmcvw4tjM7Dv0uWTnOoqGjFOZCXvDxNuvVVM5fCD3nzc5Rr6bkHm68ZBvCaQtlwqZAID');
}elseif($pageID == "530951440254946"){
	define('BOT_TOKEN', 'EAAR9nHZBpogcBAMghZBAQ2sIqVGYJITZCSUvaXb7RCwawDhQZBnLyiKUNS1C9IP6TE6PbWMbS0PJ831EdW89bAbW7yjVUq1bs9lngfFkga60PzJCr04Nm4qEeqR6ZAlLb1WpohevhnceZATuIKdUIZBJ7ZAJZCX9ZBtFZAvq6EZAW1wKgtCBYMZCopzNw');
	//
}elseif($pageID == "523235258054632"){
	define('BOT_TOKEN', 'EAAR9nHZBpogcBAO8YPvKkh1J8oeBgRbmDZAxeIoU9QdN7PzWanv5SrHIlVkZA5XZC5B4WtCvhsebzCy3wf4DWhZCMFRZCFPgWqYkbjUMm0y3V7niLB24hzJvGdVb5eokhbMH1EKxtP2jkdRgXAm8zMG9iMe03HvHroUmgchPHsOVj8OIljnpsK');
}
define('API_URL', 'https://graph.facebook.com/v2.11/me/messages?access_token='.BOT_TOKEN);
//wfile("BOTTOKEN: ".(BOT_TOKEN));

if (isset($update['entry'][0]['messaging'][0])) {

	$senderID = $update['entry'][0]['messaging'][0]['sender']['id'];

	$blocked = getUserLocked($pageID, $senderID);
	wfile("Send message: ".($blocked));
	if($blocked == "yes"){
  	processMessage($update['entry'][0]['messaging'][0]);
	}else{
		wfile("Not supposed to send the message!");
	}
}





function wfile($text){
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	$filename = 'teste.txt';
	$conteudo = date('d/m/Y H:i:s').' ('.$ip.') - '.$text."\n";

	// Primeiro vamos ter certeza de que o arquivo existe e pode ser alterado
	if (is_writable($filename)) {

	 // Em nosso exemplo, nós vamos abrir o arquivo $filename
	 // em modo de adição. O ponteiro do arquivo estará no final
	 // do arquivo, e é pra lá que $conteudo irá quando o
	 // escrevermos com fwrite().
		if (!$handle = fopen($filename, 'a')) {
			 //echo "Não foi possível abrir o arquivo ($filename)";
			 exit;
		}

		// Escreve $conteudo no nosso arquivo aberto.
		if (fwrite($handle, $conteudo) === FALSE) {
			//echo "Não foi possível escrever no arquivo ($filename)";
			exit;
		}

		//echo "Sucesso: Escrito ($conteudo) no arquivo ($filename)";

		fclose($handle);

	} else {
		//echo "O arquivo $filename não pode ser alterado";
	}
}

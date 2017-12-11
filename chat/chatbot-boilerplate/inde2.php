<?php
	
$verify_token = "Senha1234";
$hub_verify_token = null;
wfile("---------------------------------");

if(isset($_REQUEST['hub_challenge'])) {
    $challenge = $_REQUEST['hub_challenge'];
    $hub_verify_token = $_REQUEST['hub_verify_token'];
}


if ($hub_verify_token === $verify_token) {
    echo $challenge;
}


// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);
wfile("Input: ".file_get_contents('php://input'));
$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];
$answer = "I don't understand. Ask me 'hi'."
if($messageText == "hi") {
    $answer = "Hello";
}
$response = [
    'recipient' => [ 'id' => $senderId ],
    'message' => [ 'text' => $answer ]
];

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://graph.facebook.com/v2.6/me/messages?access_token=EAAR9nHZBpogcBADSfPLSfXPyrNZBKpQetOFTwAEZBjdnTXVqgsHnS7ZCrZBNYFeqMxIwmxpT1bDNe1sjJtALbxtOgDmHojjTlGKh6mcian1t2e7ZCtd1V8Nsd4oL3Vg0DMguwU2V5idqInulJjRQmJB0qtd7aqSwUQm0J2PQc1o8AXFVi38JmR",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n    recipient: {id:".$senderId."},\n    message: {text: \"".$answer."\"}\n}",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  wfile("cURL Error #:" . $err);
} else {
  wfile($response);
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
<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
wfile("Pagina solicitada pelo IP ".$ip);

require_once __DIR__ . '/vendor/autoload.php';
use App\ChatbotHelper;

// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();

// Facebook webhook verification
$chatbotHelper->verifyWebhook($_REQUEST);

wfile("Webhook verificado");
wfile("Helper: ".$chatbotHelper);

// Get the fb users data
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $chatbotHelper->getSenderId($input);

wfile("Sender ID: ".$senderId);
if ($senderId && $chatbotHelper->isMessage($input)) {

    // Get the user's message
    $message = $chatbotHelper->getMessage($input);
	wfile("Mensagem recebida: ".$message);

    // Example 1: Get a static message back
    $replyMessage = $chatbotHelper->getAnswer($message);

    // Example 2: Get foreign exchange rates
    // $replyMessage = $chatbotHelper->getAnswer($message, 'rates');

    // Example 3: If you want to use a bot platform like api.ai
    // Don't forget to place your Api.ai Client access token in the .env file
    // $replyMessage = $chatbotHelper->getAnswer($message, 'apiai');

    // Example 4: If you want to use a bot platform like wit.ai
    // Don't forget to place your Wit.ai Client access token in the .env file (WITAI_TOKEN)
    // $replyMessage = $chatbotHelper->getAnswer($message, 'witai');

    // Send the answer back to the Facebook chat
    $chatbotHelper->send($senderId, $replyMessage);

}




function wfile($text){
	$filename = 'teste.txt';
	$conteudo = date('d/m/Y H:i:s').' - '.$text."\n";

	// Primeiro vamos ter certeza de que o arquivo existe e pode ser alterado
	if (is_writable($filename)) {

	 // Em nosso exemplo, nós vamos abrir o arquivo $filename
	 // em modo de adição. O ponteiro do arquivo estará no final
	 // do arquivo, e é pra lá que $conteudo irá quando o 
	 // escrevermos com fwrite().
		if (!$handle = fopen($filename, 'a')) {
			 echo "Não foi possível abrir o arquivo ($filename)";
			 exit;
		}

		// Escreve $conteudo no nosso arquivo aberto.
		if (fwrite($handle, $conteudo) === FALSE) {
			echo "Não foi possível escrever no arquivo ($filename)";
			exit;
		}

		echo "Sucesso: Escrito ($conteudo) no arquivo ($filename)";

		fclose($handle);

	} else {
		echo "O arquivo $filename não pode ser alterado";
	}
}
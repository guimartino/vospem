<?php
require_once __DIR__ . '/vendor/autoload.php';
use App\ChatbotHelper;
$filename = "texto.txt";
$fh = fopen($filename, "a");
// Create the chatbot helper instance
$chatbotHelper = new ChatbotHelper();

// Facebook webhook verification
$chatbotHelper->verifyWebhook($_REQUEST);

// Get the fb users data
$input = json_decode(file_get_contents('php://input'), true);
$senderId = $chatbotHelper->getSenderId($input);
$t = date("d/m/Y - H:i:s") . ": Sender ID = ". $senderId."\n";
fwrite($fh, $t);
if ($senderId && $chatbotHelper->isMessage($input)) {
	
    // Get the user's message
    $message = $chatbotHelper->getMessage($input);
	$t = date("d/m/Y - H:i:s") . ": Mensagem = ". $message."\n";
	fwrite($fh, $t);
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


fclose($fh);

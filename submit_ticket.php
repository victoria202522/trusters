<?php
header('Content-Type: application/json');

// Enable detailed errors during testing
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Telegram config
$botToken = "8072535178:AAEECwdN4jeLk3qQBQq1NaqObmHAcQ8uOZI";
$adminChatId = "1129243973";

// DB config
$cn = new mysqli("localhost", "root", "", "dapp");
if ($cn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'DB connection failed: ' . $cn->connect_error]);
    exit;
}

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
    exit;
}

// Receive and sanitize input
$email = trim($_POST['email'] ?? '');
$environment = trim($_POST['environment'] ?? '');
$issue = trim($_POST['issue'] ?? '');
$status = 0;

if (!$email || !$environment || !$issue) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

// Check for duplicate
$check = $cn->prepare("SELECT id FROM user WHERE email = ? AND status = 0 LIMIT 1");
if (!$check) {
    echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $cn->error]);
    exit;
}
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Ticket already submitted.']);
    exit;
}

// Insert ticket
$stmt = $cn->prepare("INSERT INTO user (email, enviroment, issue, status) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Insert prepare failed: ' . $cn->error]);
    exit;
}
$stmt->bind_param("sssi", $email, $environment, $issue, $status);
if (!$stmt->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Insert failed: ' . $stmt->error]);
    exit;
}
$ticketId = $stmt->insert_id;

// Generate token
$approve_token = bin2hex(random_bytes(16));

// Save token
$update = $cn->prepare("UPDATE user SET approve_token = ? WHERE id = ?");
if (!$update) {
    echo json_encode(['status' => 'error', 'message' => 'Token update prepare failed: ' . $cn->error]);
    exit;
}
$update->bind_param("si", $approve_token, $ticketId);
if (!$update->execute()) {
    echo json_encode(['status' => 'error', 'message' => 'Token update failed: ' . $update->error]);
    exit;
}

// Build URL
$baseUrl = "http://localhost.com/defiapp/approve_ticket.php";
$approveUrl = "$baseUrl?id=$ticketId&token=$approve_token";

// Build Telegram content
$message = "🛠 *New Support Ticket*\n\n" .
           "📧 Email: `$email`\n" .
           "🌍 Environment: `$environment`\n" .
           "📝 Issue: `$issue`\n\n" .
           "Click the button below to approve:";

$keyboard = [
    "inline_keyboard" => [
        [
            ["text" => "✅ Approve Ticket", "url" => $approveUrl]
        ]
    ]
];

// Send Telegram message
$response = file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?" . http_build_query([
    'chat_id' => $adminChatId,
    'text' => $message,
    'parse_mode' => 'Markdown',
    'reply_markup' => json_encode($keyboard),
    'disable_web_page_preview' => true
]));

// Check Telegram response
$tgData = json_decode($response, true);
if (!$tgData || !$tgData['ok']) {
    echo json_encode(['status' => 'error', 'message' => 'Telegram error: ' . $response]);
    exit;
}

echo json_encode(['status' => 'success', 'message' => 'Ticket submitted successfully.']);
?>

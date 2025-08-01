<?php
// approve_ticket.php

// DB config
$cn = new mysqli("localhost", "root", "", "dapp");
if ($cn->connect_error) {
    die("❌ Database connection failed.");
}

// Get ticket ID and token from URL
$id = intval($_GET['id'] ?? 0);
$token = $_GET['token'] ?? '';

// Fetch the ticket using `approve_token`
$stmt = $cn->prepare("SELECT email FROM user WHERE id = ? AND approve_token = ? AND status = 0 LIMIT 1");
$stmt->bind_param("is", $id, $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("❌ Ticket already approved or token invalid.");
}

$row = $result->fetch_assoc();
$user_email = $row['email'];

// Generate secure access token
$access_token = bin2hex(random_bytes(32));

// Set expiry time to 1 hour from now
$expires_at = date('Y-m-d H:i:s', time() + 900);

// Update ticket: status = 1, token = access_token, timer = expires_at
$update = $cn->prepare("UPDATE user SET status = 1, token = ?, timer = ? WHERE id = ?");
$update->bind_param("ssi", $access_token, $expires_at, $id);
$update->execute();

// ========== PHPMailer Setup ==========
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

// Mail config
$web_mail     = 'info@yourdomain.com';
$email_psd    = 'yourpassword';
$company_name = 'LooperQ';

// Email content
$link = "http://localhost/defiapp/continue_ticket.php?token=$access_token";
$body = "
    <p>Hello,</p>
    <p>Your ticket has been approved. Click the button below to continue securely:</p>
    <p><a href='$link' style='padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none;'>Continue</a></p>
    <p>This link will expire in 1 hour.</p>
";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $web_mail;
    $mail->Password   = $email_psd;
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;

    $mail->setFrom($web_mail, $company_name);
    $mail->addAddress($user_email);

    $mail->isHTML(true);
    $mail->Subject = 'Your Secure Ticket Link';
    $mail->Body    = $body;

    $isLocal = true;

    if ($isLocal) {
        file_put_contents('mail_log.txt', "TO: $user_email\n\n$body\n\n---\n", FILE_APPEND);
    } else {
        $mail->send();
    }

    echo "✅ Ticket approved and email sent (or logged).";
} catch (Exception $e) {
    echo "❌ Mailer Error: {$mail->ErrorInfo}";
    error_log("Mailer Error: {$mail->ErrorInfo}");
}
?>

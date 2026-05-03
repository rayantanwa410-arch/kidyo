<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Direct access to this script is not allowed.";
    exit;
}

// Destination email
$to = "kidyourconfidence.org@gmail.com";

// Helper to remove header injection characters
function clean_header_input($value) {
    return str_replace(array("\r", "\n"), '', trim($value));
}

// Collect & validate form data
$name = isset($_POST['name']) ? strip_tags(clean_header_input($_POST['name'])) : '';
$from_email = isset($_POST['email']) ? filter_var(clean_header_input($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST['message']) ? trim($_POST['message']) : '';

$errors = [];
if (empty($name)) {
    $errors[] = 'Name is required.';
}
if (empty($from_email) || !filter_var($from_email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'A valid email is required.';
}
if (empty($message)) {
    $errors[] = 'Message is required.';
}

if (!empty($errors)) {
    // Redirect back with a validation error flag
    header('Location: contact.html?error=validation');
    exit;
}

// Prepare email
$subject = "New message from $name";
$email_body = "You have received a new message from your website contact form.\n\n" .
    "Name: $name\n" .
    "Email: $from_email\n\n" .
    "Message:\n" . htmlspecialchars($message) . "\n";

// Use a domain-based From address if possible. Change to a valid address on your server.
$from_header = 'no-reply@kidyourconfidence.org';
$headers = "From: " . $from_header . "\r\n";
$headers .= "Reply-To: " . $from_email . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

// Attempt to send mail
if (mail($to, $subject, $email_body, $headers)) {
    header('Location: contact.html?success=1');
    exit;
} else {
    header('Location: contact.html?error=send');
    exit;
}
?>
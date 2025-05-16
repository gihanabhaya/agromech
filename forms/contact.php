<?php
// Replace this with your real email address
$receiving_email_address = "agromechinternational@gmail.com";

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validate and sanitize input
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST["subject"]));
    $message = trim($_POST["message"]);

    // Check required fields
    if (empty($name) || empty($email) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill in all required fields correctly.";
        exit;
    }

    // Prepare the email
    $email_subject = "New Contact Message: $subject";
    $email_body = "From: $name\n";
    $email_body .= "Email: $email\n";
    $email_body .= "Subject: $subject\n\n";
    $email_body .= "Message:\n$message\n";

    $headers = "From: $name <$email>";

    // Send the email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        http_response_code(200);
        echo "Message sent successfully!";
    } else {
        http_response_code(500);
        echo "Error sending message. Please try again later.";
    }

} else {
    // Not a POST request
    http_response_code(403);
    echo "Invalid request.";
}
?>

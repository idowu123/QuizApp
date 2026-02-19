<?php
header("Content-Type: application/json");

// Example: store all passkeys in an array
$passkeys = [
    "12345",
    "abcdef",
    "pass123"
];

// Get the passkey from POST request
$enteredKey = isset($_POST['passkey']) ? trim($_POST['passkey']) : '';

if ($enteredKey === '') {
    echo json_encode(["status" => "error", "message" => "No passkey entered"]);
    exit;
}

// Check if the entered key exists
if (in_array($enteredKey, $passkeys)) {
    echo json_encode(["status" => "success", "message" => "Passkey activated!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid passkey"]);
}
?>
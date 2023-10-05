<?php
session_start(); // Start the PHP session

// Get the current User-Agent
$userAgent = $_SERVER['HTTP_USER_AGENT'];

// Replace 'your_secret_salt_here' with a strong secret salt
$salt = 'your_secret_salt_here';

// Function to generate a secure cookie key based on User-Agent and session ID
function generateCookieKey($userAgent, $sessionId, $salt) {
    $dataToEncrypt = $userAgent . '|' . $sessionId;
    $encryptedData = base64_encode($dataToEncrypt ^ $salt);
    return $encryptedData;
}

// Function to decrypt the cookie key
function decryptCookieKey($encryptedKey, $salt) {
    $decryptedData = base64_decode($encryptedKey);
    return $decryptedData ^ $salt;
}

// Your $_SESSION['id']
$sessionId = $_SESSION['id'];

// Generate the cookie key
$encryptedKey = generateCookieKey($userAgent, $sessionId, $salt);

// Set the cookie with the encrypted key
setcookie('user_info', $encryptedKey, time() + 30 * 24 * 60 * 60, '/'); // Expires in 30 days

echo "Encrypted Key: $encryptedKey<br>";

// Retrieve the encrypted key from the cookie
$cookieValue = $_COOKIE['user_info'];

// Decrypt the cookie key
$decryptedData = decryptCookieKey($cookieValue, $salt);

// Split the decrypted data into User-Agent and session ID
list($decryptedUserAgent, $decryptedSessionId) = explode('|', $decryptedData);

echo "Decrypted User-Agent: $decryptedUserAgent<br>";
echo "Decrypted Session ID: $decryptedSessionId<br>";

// Check if the decrypted User-Agent and session ID match the current values
if ($decryptedUserAgent === $userAgent && $decryptedSessionId === $sessionId) {
    echo "User-Agent and Session ID Matched!";
} else {
    echo "User-Agent or Session ID Mismatch!";
}
?>

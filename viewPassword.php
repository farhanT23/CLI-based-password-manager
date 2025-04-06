<?php

require_once 'functions.php';

$masterPassword = verifyMasterPassword();

$entries = loadPasswords();
if (empty($entries)) {
    echo "No entries stored yet.\n";
    exit;
}

echo "Enter title to view (e.g., Gmail): ";
$title = trim(fgets(STDIN));

$found = false;

foreach ($entries as $entry) {
    if ($entry['title'] === $title) {
        $found = true;

        
        $encryptedPassword = $entry['password'];
        $decryptedPassword = decrypt_password($encryptedPassword, $masterPassword);
        if ($decryptedPassword === false) {
            echo "Error decrypting password!\n";
            exit;
        }

        
        $username = isset($entry['username']) ? $entry['username'] : "No username stored";
        echo "Service: $title\n";
        echo "Username: $username\n";
        echo "Password has been copied to clipboard.\n";

        
        copyToClipboard($decryptedPassword);
        break;
    }
}

if (!$found) {
    echo "No entry found with the title '$title'.\n";
}
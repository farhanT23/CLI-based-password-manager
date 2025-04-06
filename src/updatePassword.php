<?php
require_once __DIR__ . '/../lib/functions.php';

$masterPassword = verifyMasterPassword();

$entries = loadPasswords();
if (empty($entries)) {
    echo "No passwords stored yet.\n";
    exit;
}

echo "Enter service name to update (e.g., Gmail): ";
$title = trim(fgets(STDIN));

$found = false;

foreach ($entries as $index => $entry) {
    if ($entry['title'] === $title) {
        $found = true;

        echo "Enter new password for $title: ";
        $newPassword = hiddenInput("Enter new password: ");
        $confirmPassword = hiddenInput("Confirm new password: ");
        if ($newPassword !== $confirmPassword) {
            echo "Passwords didn't match.\n";
            exit;
        }

        $encryptedPassword = encrypt_password($newPassword, $masterPassword);

        $entries[$index]['password'] = $encryptedPassword;
        savePasswords($entries);
        echo "Password for '$title' updated successfully!\n";
        break;
        
    }
}


if (!$found) {
    echo "No entry found with the title '$title'.\n";
}

exit;
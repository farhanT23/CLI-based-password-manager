<?php
require_once 'functions.php';

$masterPassword = verifyMasterPassword();

$entries = loadPasswords();
if (empty($entries)) {
    echo "No passwords stored yet.\n";
    exit;
}

echo "Enter service name to delete (e.g., Gmail): ";
$title = trim(fgets(STDIN));

$found = false;

foreach ($entries as $index => $entry) {
    if ($entry['title'] === $title) {
        $found = true;

        unset($entries[$index]);

        savePasswords($entries);

        echo "Password entry for '$title' deleted successfully!\n";
        break;
    }
}

if (!$found) {
    echo "No entry found with the title '$title'.\n";
}
?>
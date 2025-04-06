<?php

require_once 'functions.php';

echo "=== CLI PASSWORD MANAGER ===\n";

if (!isMasterPasswordSet()) {
    setMasterPassword();
} else {
    verifyMasterPassword();
}

while (true) {
    echo "\n=== Password Manager ===\n";
    echo "1. Add New Password\n";
    echo "2. View Passwords\n";
    echo "3. Exit\n";
    echo "Choose an option: ";

    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case '1':
            require 'addPassword.php';
            break;

        case '2':
            require 'viewPasswords.php';
            break;

        case '3':
            echo "Goodbye!\n";
            exit;

        default:
            echo "Invalid option. Try again.\n";
    }
}

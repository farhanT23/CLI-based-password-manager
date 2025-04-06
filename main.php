<?php

require_once 'functions.php';

echo "=== CLI PASSWORD MANAGER ===\n";

if (!isMasterPasswordSet()) {
    setMasterPassword();
} else {
    verifyMasterPassword();
}

function mainMenu() {

    echo "\n=== Main Menu ===\n";
    echo "1. Add New Password\n";
    echo "2. View Passwords\n";
    echo "3. Exit\n";
    echo "Choose an option: ";

}

while (true) {
    
    mainMenu();

    $choice = trim(fgets(STDIN));

    switch ($choice) {
        case '1':
            require_once 'addPassword.php';
            break;

        case '2':
            require_once 'viewPasswords.php';
            break;

        case '3':
            echo "Goodbye!\n";
            exit;

        default:
            echo "Invalid option. Try again.\n";
    }
}

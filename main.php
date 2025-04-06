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
    echo "3. Delete Password\n";
    echo "4. Update Password\n";
    echo "5. Exit\n";
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
            require_once 'viewPassword.php';
            break;
        
        case '3':
            require_once 'deletePassword.php';
            break;
        
        case '4':
            require_once 'updatePassword.php';
            break;

        case '5':
            echo "Goodbye!\n";
            exit;


        default:
            echo "Invalid option. Try again.\n";
    }
}

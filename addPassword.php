<?php 
require_once 'functions.php';

function validation($title, $username, $password, $confirm) {

    if ($password !== $confirm) {
        echo "Passwords didn't match.\n";
        return false;
    }
    if (empty($title) || empty($username) || empty($password)) {
        echo "All fields are required.\n";
        return false;
    }

    $entries = loadPasswords();
    
    if (empty($entries)) {
        return true;
    }

    foreach ($entries as $entry) {
        if ($entry['title'] === $title) {
            echo "Title already exists. Please choose a different title.\n";
            return false;
        }
    }

    return true;
    
}

function addPasswordEntry() {
    echo "\nAdd New Password Entry:\n";
    echo "Title: ";
    $title = trim(fgets(STDIN));
    echo "Username: ";
    $username = trim(fgets(STDIN));
    $password = hiddenInput("Password: ");
    $confirm = hiddenInput("Confirm Password: ");
    
    $validationStatus = validation($title, $username, $password, $confirm);
    if (!$validationStatus) {
        addPasswordEntry();
        return;
    }
    

    $entries = loadPasswords();
    $id = uniqid("entry_", true);

    $encrypted_password = encrypt_password($password);

    $entries[] = [
        'id' => $id,
        'title' => $title,
        'username' => $username,
        'password' => $encrypted_password
    ];


    savePasswords($entries);
    echo "Entry saved successfully!\n";
    
    echo "Do you want to add another entry? (y/n): ";
    $choice = trim(fgets(STDIN));
    if (strtolower($choice) === 'y') {
        addPasswordEntry();
    } else {
        exit;
    }
    
}

addPasswordEntry();
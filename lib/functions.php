<?php
require_once 'config.php';

function hiddenInput($prompt = 'Enter password: ') {
    if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
        // Windows
        echo $prompt;
        $vbscript = sys_get_temp_dir() . 'prompt_password.vbs';
        file_put_contents($vbscript, 'wscript.echo(InputBox("' . addslashes($prompt) . '", "", ""))');
        $command = "cscript //nologo " . escapeshellarg($vbscript);
        $password = rtrim(shell_exec($command));
        unlink($vbscript);
        return $password;
    } else {
        // Unix-like
        echo $prompt;
        system('stty -echo');
        $password = rtrim(fgets(STDIN), "\n");
        system('stty echo');
        echo "\n";
        return $password;
    }
}

function isMasterPasswordSet() {
    return file_exists('storage/master.hash');
}

function setMasterPassword() {
    echo "First time setup: Set your master password.\n";

    $password = hiddenInput("Enter new master password: ");
    $confirm  = hiddenInput("Confirm master password: ");

    if ($password !== $confirm) {
        echo "Passwords didn't match.\n";
        exit;
    }

    $hashedPass = password_hash($password, PASSWORD_BCRYPT);
    if (!is_dir('storage')) {
        mkdir('storage');
    }
    file_put_contents('storage/master.hash', $hashedPass);
    echo "Master password set successfully!\n";
}

function verifyMasterPassword() {
    $storedHash = file_get_contents('storage/master.hash');
    $tries = 3;

    while ($tries > 0) {
        $password = hiddenInput("Enter master password: ");
        if (password_verify($password, $storedHash)) {
            echo "Access granted.\n";
            return true;
        }
        $tries--;
        echo "Incorrect password. Tries left: $tries\n";
    }

    echo "Too many failed attempts. Exiting.\n";
    exit;
}

function loadPasswords() {
    $file = 'storage/passwords.json';
    if (!file_exists($file)) {
        return [];
    }
    $json = file_get_contents($file);
    return json_decode($json, true);
}

function savePasswords($passwords) {
    $json = json_encode($passwords, JSON_PRETTY_PRINT);
    file_put_contents('storage/passwords.json', $json);
}

function encrypt_password($password) {
    return openssl_encrypt($password, CIPHER_METHOD, ENCRYPTION_KEY, 0, ENCRYPTION_IV);
}

function decrypt_password($encrypted) {
    return openssl_decrypt($encrypted, CIPHER_METHOD, ENCRYPTION_KEY, 0, ENCRYPTION_IV);
}

function copyToClipboard($text) {
    if (strncasecmp(PHP_OS, 'WIN', 3) == 0) {
        $result = exec('echo ' . escapeshellarg($text) . ' | clip');
        if ($result === false) {
            echo "Failed to copy to clipboard. Ensure 'clip' is available in your PATH.\n";
        }
    } else {
        if (exec('command -v pbcopy')) {
            exec('echo ' . escapeshellarg($text) . ' | pbcopy');
        } elseif (exec('command -v xclip')) {
            exec('echo ' . escapeshellarg($text) . ' | xclip -selection clipboard');
        } elseif (exec('command -v xsel')) {
            exec('echo ' . escapeshellarg($text) . ' | xsel --clipboard --input');
        } else {
            echo "Failed to copy to clipboard. Install 'pbcopy', 'xclip', or 'xsel'.\n";
        }
    }
}
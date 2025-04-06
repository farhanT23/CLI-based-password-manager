<?php

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
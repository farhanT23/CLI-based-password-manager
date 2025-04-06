<?php

function hidden_input($prompt = 'Enter password: ') {
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
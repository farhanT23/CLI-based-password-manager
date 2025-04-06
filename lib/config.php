<?php
define('ENCRYPTION_KEY', 'wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY==');
define('CIPHER_METHOD', 'AES-256-CBC');
define('ENCRYPTION_IV', substr(hash('sha256', 'GkZpQ2xvV1pXb3JkU2VjdXJl'), 0, 16));

<?php

require_once 'functions.php';

echo "=== CLI PASSWORD MANAGER ===\n";

if (!isMasterPasswordSet()) {
    setMasterPassword();
} else {
    verifyMasterPassword();
}



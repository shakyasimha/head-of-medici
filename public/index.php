<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Account;

$account = new Account();
echo "Account Balance: Rs." . $account->getBalance();

<?php

namespace App;

class Account
{
    public function __construct(
        private float $balance = 0.00,
    ) {}

    public function getBalance(): float
    {
        return $this->balance;
    }
}

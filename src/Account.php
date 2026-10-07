<?php

namespace App\Models;

use PDO;
use App\Database;
use DateTime;

class Account
{
    public function __construct(
        private ?string $id,
        private string $customerId,
        private string $accountNumber,
        private string $accountType,
        private string $currency,
        private float $balance,
        private string $status,
        private DateTime $createdAt,
        private DateTime $updatedAt
    ) {}

    // Getters 
    public function getId(): ?string
    {
        return $this->id;
    }
    public function getCustomerId(): string
    {
        return $this->customerId;
    }
    public function getAccountNumber(): string
    {
        return $this->accountNumber;
    }
    public function getAccountType(): string
    {
        return $this->accountType;
    }
    public function getCurrency(): string
    {
        return $this->currency;
    }
    public function getBalance(): float
    {
        return $this->balance;
    }
    public function getStatus(): string
    {
        return $this->status;
    }
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    // Domain Mutators
    public function setBalance(float $balance): void
    {
        $this->balance = $balance;
        $this->updatedAt = new DateTime();
    }
}

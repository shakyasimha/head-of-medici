<?php

namespace App\Repositories;

use App\Database;
use App\Models\Account;
use DateTime;
use PDO;

class AccountRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findById(string $id): ?Account
    {
        $stmt = $this->db->prepare("SELECT * FROM accounts WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        // Hydate and return an Account instance
        return new Account(
            id: (string) $row['id'],
            customerId: (string) $row['customerId'],
            accountNumber: $row['account_number'],
            accountType: $row['account_type'],
            currency: $row['currency'],
            balance: (float) $row['balance'],
            status: $row['status'],
            createdAt: new DateTime($row['created_at']),
            updatedAt: new DateTime($row['updated_at'])
        );
    }
}

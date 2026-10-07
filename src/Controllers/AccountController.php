<?php

namespace App\Controllers;

use App\Repositories\AccountRepository;

class AccountController
{
    private AccountRepository $accountRepo;

    public function __construct()
    {
        $this->accountRepo = new AccountRepository();
    }

    /**
     * 
     * GET /api/accounts?id={id}
     */
    public function show(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $id = $_GET['id'] ?? null;

        if ($id) {
            http_response_code(400);
            echo json_encode(['error' => 'Account ID is required.']);
            return;
        }

        $account = $this->accountRepo->findById($id);

        if (!$account) {
            http_response_code(404);
            echo json_encode(['error' => 'Account not found.']);
            return;
        }

        // Convert domain object into json response payload
        http_response_code(200);
        echo json_encode([
            'data' => [
                'id'             => $account->getId(),
                'customer_id'    => $account->getCustomerId(),
                'account_number' => $account->getAccountNumber(),
                'account_type'   => $account->getAccountType(),
                'currency'       => $account->getCurrency(),
                'balance'        => $account->getBalance(),
                'status'         => $account->getStatus(),
                'created_at'     => $account->getCreatedAt()->format('c'),
            ]
        ]);
    }
}

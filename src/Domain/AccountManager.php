<?php

namespace App\Domain;

class AccountManager {

    private array $accounts = [];

    public function createAccount(string $accountId, int $initialBalance): array
    {
        if (!isset($this->accounts[$accountId])) {
            $this->accounts[$accountId] = ['id' => $accountId, 'balance' => $initialBalance];
        } else {
            $this->accounts[$accountId]['balance'] += $initialBalance;
        }
        return $this->accounts[$accountId];
    }

    public function reset(): void
    {
        
    }

    public function getBalance(string $accountId): ?int
    {
        
    }

}
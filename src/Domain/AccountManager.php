<?php

namespace App\Domain;

class AccountManager {

    private array $accounts = [];

    public function manageAccount(string $accountId, int $initialBalance): array
    {
        if (!isset($this->accounts[$accountId])) {
            $this->accounts[$accountId] = ['id' => $accountId, 'balance' => $initialBalance];
        } else {
            $this->accounts[$accountId]['balance'] += $initialBalance;
        }
        return $this->accounts[$accountId];
    }

    public function getBalance(string $accountId): ?int
    {
        return $this->accounts[$accountId]['balance'] ?? null;
    }

    public function reset(): void
    {
        $this->accounts = [];
    }

    public function withdraw(string $accountId, int $amount): ?array
    {
        if (!isset($this->accounts[$accountId])) {
            return null;
        }

        $this->accounts[$accountId]['balance'] -= $amount;

        return $this->accounts[$accountId];
    }

    public function transfer(string $originId, string $destinationId, int $amount): ?array
    {
        if (!isset($this->accounts[$originId])) {
            return null;
        }

        $this->withdraw($originId, $amount);
        $destinationAccount = $this->manageAccount($destinationId, $amount);

        return [
            'origin' => $this->accounts[$originId],
            'destination' => $destinationAccount,
        ];
    }
    
}
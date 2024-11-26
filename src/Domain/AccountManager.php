<?php

namespace App\Domain;

class AccountManager {

    private string $filePath;
    private array $accounts = [];

    public function __construct(string $filePath = 'accounts.json')
    {
        $this->filePath = $filePath;
        $this->loadAccounts();
    }

    public function __destruct()
    {
        $this->saveAccounts();
    }

    private function loadAccounts(): void
    {
        if (file_exists($this->filePath)) {
            $jsonContent = file_get_contents($this->filePath);
            $this->accounts = json_decode($jsonContent, true) ?? [];
        }
    }

    private function saveAccounts(): void
    {
        file_put_contents($this->filePath, json_encode($this->accounts, JSON_PRETTY_PRINT));
    }

    public function manageAccount(string $accountId, int $initialBalance): array
    {
        if (!isset($this->accounts[$accountId])) {
            $this->accounts[$accountId] = ['id' => $accountId, 'balance' => $initialBalance];
        } else {
            $this->accounts[$accountId]['balance'] += $initialBalance;
        }
        $this->saveAccounts(); 
        return $this->accounts[$accountId];
    }

    public function getBalance(string $accountId): ?int
    {
        return $this->accounts[$accountId]['balance'] ?? null;
    }

    public function reset(): void
    {
        $this->accounts = [];
        $this->saveAccounts(); 
    }

    public function withdraw(string $accountId, int $amount): ?array
    {
        if (!isset($this->accounts[$accountId])) {
            return null;
        }

        $this->accounts[$accountId]['balance'] -= $amount;
        $this->saveAccounts(); 

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

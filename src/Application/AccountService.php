<?php

namespace App\Application;

use App\Domain\AccountManager;

class AccountService
{
    private AccountManager $manager;

    public function __construct(AccountManager $manager)
    {
        $this->manager = $manager;
    }

    public function resetState(): void
    {
        $this->manager->reset();
    }

    public function getBalance(string $accountId): ?int
    {
        return $this->manager->getBalance($accountId);
    }

    public function deposit(string $accountId, int $amount): array
    {
        return $this->manager->manageAccount($accountId, $amount);
    }

    public function withdraw(string $accountId, int $amount): ?array
    {
        return $this->manager->withdraw($accountId, $amount);
    }

    public function transfer(string $originId, string $destinationId, int $amount): ?array
    {
        return $this->manager->transfer($originId, $destinationId, $amount);
    }

}
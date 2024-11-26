<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\AccountManager;
use App\Application\AccountService;

class AccountServiceTest extends TestCase {

    private AccountService $service;

    protected function setUp(): void
    {
        $manager = new AccountManager();
        $this->service = new AccountService($manager);
    }

}


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
    
    public function testResetState(): void
    {
        $this->service->deposit('100', 50);
        $this->service->resetState();
        $balance = $this->service->getBalance('100');
        $this->assertNull($balance);
    }

    public function testGetBalanceForExistingAccount(): void
    {
        $this->service->deposit('100', 50);
        $balance = $this->service->getBalance('100');
        $this->assertEquals(50, $balance);
    }

    public function testGetBalanceForNonExistingAccount(): void
    {
        $balance = $this->service->getBalance('999');
        $this->assertNull($balance);
    }


}


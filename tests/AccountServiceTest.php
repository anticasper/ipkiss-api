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

    public function testDeposit(): void
    {
        $account = $this->service->deposit('100', 20);
        $this->assertEquals(['id' => '100', 'balance' => 20], $account);
    }

    public function testWithdrawFromExistingAccount(): void
    {
        $this->service->deposit('100', 30);
        $account = $this->service->withdraw('100', 10);
        $this->assertEquals(['id' => '100', 'balance' => 20], $account);
    }

    public function testWithdrawFromNonExistingAccount(): void
    {
        $account = $this->service->withdraw('999', 10);
        $this->assertNull($account);
    }

}


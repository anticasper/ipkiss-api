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
        $this->service->resetState();
        $this->service->deposit('100', 50);
        $balance = $this->service->getBalance('100');
        $this->assertEquals(50, $balance);
    }

    public function testGetBalanceForNonExistingAccount(): void
    {
        $this->service->resetState();
        $balance = $this->service->getBalance('999');
        $this->assertNull($balance);
    }

    public function testDeposit(): void
    {
        $this->service->resetState();
        $account = $this->service->deposit('100', 20);
        $this->assertEquals(['id' => '100', 'balance' => 20], $account);
    }

    public function testWithdrawFromExistingAccount(): void
    {
        $this->service->resetState();
        $this->service->deposit('100', 30);
        $account = $this->service->withdraw('100', 10);
        $this->assertEquals(['id' => '100', 'balance' => 20], $account);
    }

    public function testWithdrawFromNonExistingAccount(): void
    {
        $this->service->resetState();
        $account = $this->service->withdraw('999', 10);
        $this->assertNull($account);
    }

    public function testTransfer(): void
    {
        $this->service->resetState();
        $this->service->deposit('100', 30);
        $result = $this->service->transfer('100', '200', 10);

        $this->assertEquals(['id' => '100', 'balance' => 20], $result['origin']);
        $this->assertEquals(['id' => '200', 'balance' => 10], $result['destination']);
    }

}


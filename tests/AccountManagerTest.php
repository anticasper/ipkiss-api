<?php 

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Domain\AccountManager;

class AccountManagerTest extends TestCase {

    private AccountManager $manager;

    protected function setUp(): void
    {
        $this->manager = new AccountManager();
    }

    public function testAccountCreation(): void
    {
        $account = $this->manager->manageAccount('100', 10);
        $this->assertEquals(['id' => '100', 'balance' => 10], $account);
    }

    public function testGetBalance(): void{
        $this->manager->manageAccount('100', 50);
        $balance = $this->manager->getBalance('100');
        $this->assertEquals(50, $balance);
    }

    public function testReset(): void{
        $this->manager->manageAccount('100', 50);
        $this->manager->reset();
        $this->assertNull($this->manager->getBalance('100'));
    }

    public function testDepositIntoExistingAccount(): void
    {
        $this->manager->manageAccount('100', 10);
        $account = $this->manager->manageAccount('100', 20);
        $this->assertEquals(['id' => '100', 'balance' => 30], $account);
    }

    public function testWithdrawFromExistingAccount(): void
    {
        $this->manager->manageAccount('100', 20);
        $account = $this->manager->withdraw('100', 5);
        $this->assertEquals(['id' => '100', 'balance' => 15], $account);
    }
    
    public function testWithdrawFromNonExistingAccount(): void
    {
        $this->manager->manageAccount('100', 20);
        $account = $this->manager->withdraw('101', 5);
        $this->assertNull($this->manager->getBalance('101'));
    }

    public function testTransferBetweenAccounts(): void
    {
        $this->manager->manageAccount('100', 20);
        $result = $this->manager->transfer('100', '200', 10);

        $this->assertEquals(['id' => '100', 'balance' => 10], $result['origin']);
        $this->assertEquals(['id' => '200', 'balance' => 10], $result['destination']);
    }

}


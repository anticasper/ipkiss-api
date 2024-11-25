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

}


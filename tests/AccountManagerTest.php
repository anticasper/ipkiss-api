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

    public function testReset(): void{
        
    }

    public function testGetBalace(): void{

    }

}


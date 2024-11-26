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

}
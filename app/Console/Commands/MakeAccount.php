<?php

namespace App\Console\Commands;

use App\Model\Role;
use App\Model\Account;
use Illuminate\Console\Command;

class MakeAccount extends Command
{
    /**
     * @var Account
     */
    protected $account;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:root {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new account for the website access control dashboard using bCrypt.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Account $account)
    {
        parent::__construct();

        $this->account = $account;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('password')) {
            $this->account->forename = 'Mark';
            $this->account->surname = 'Hester';
            $this->account->verified = true;
            $this->account->role_id = Role::SUPERUSER;
            $this->account->password = bcrypt($this->argument('password'));
            $this->account->email = 'marky360@lvie.ie';
            $this->account->save();

            $this->info('Successfully created the root super user for this website.');

            return true;
        }

        $this->error('You must enter a valid password string to assign to the root user.');

        return false;
    }
}

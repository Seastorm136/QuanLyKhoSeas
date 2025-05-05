<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\StaffLogin;
use App\Models\AdminLogin;
use Illuminate\Support\Facades\Hash;

class HashPasswords extends Command
{
    protected $signature = 'hash:passwords';
    protected $description = 'Hash all passwords in StaffLogin and AdminLogin tables';

    public function handle()
    {
        $staffs = StaffLogin::all();
        foreach ($staffs as $staff) {
            if (!password_verify($staff->password, $staff->password)) {
                $staff->password = Hash::make($staff->password);
                $staff->save();
            }
        }

        $admins = AdminLogin::all();
        foreach ($admins as $admin) {
            if (!password_verify($admin->password, $admin->password)) {
                $admin->password = Hash::make($admin->password);
                $admin->save();
            }
        }

        $this->info('All passwords have been hashed!');
    }
}
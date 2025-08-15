<?php

namespace Database\Seeders;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Admin;
use App\Models\AccessLevel;
use App\Models\FinancialType;
use App\Models\FinancialCategory;
use App\Models\MobileBanking;
use App\Models\Setting;

use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@riniforyou.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => '00',
        ]);

        AccessLevel::create(['title' => 'Product']);
        AccessLevel::create(['title' => 'Sale']);
        AccessLevel::create(['title' => 'Employee']);
        AccessLevel::create(['title' => 'Financial']);
        AccessLevel::create(['title' => 'Project Admin']);
       
        for($i=1; $i<6; $i++){
            Admin::create([
                'user_id'=>1,
                'access_level_id'=>$i,
                'disable'=>0,
            ]);
        }
        
        FinancialType::create(['type'=>'Income']); // id 1
        FinancialType::create(['type'=>'Outcome']); // id 2s

        FinancialCategory::create(['financial_type_id'=>'2','category'=>'Salary Payment']); // id 1
        FinancialCategory::create(['financial_type_id'=>'2','category'=>'Bonus']); // id 2

        MobileBanking::create(['bank'=>'KBZ pay','icon'=>'images/payment-kbz-pay.jpg']);
        MobileBanking::create(['bank'=>'Wave pay','icon'=>'images/payment-wave-pay.jpg']);
        MobileBanking::create(['bank'=>'CB pay','icon'=>'images/payment-cb-pay.png']);
        MobileBanking::create(['bank'=>'AYA pay','icon'=>'images/payment-aya-pay.png']);//
        MobileBanking::create(['bank'=>'KBZ Bank Account','icon'=>'images/kbz_bank.png']);

        Setting::create(['content'=>'address','value'=>"Not available"]);
        Setting::create(['content'=>'email','value'=>"Not available"]);
        Setting::create(['content'=>'phone','value'=>"Not available"]);

        Setting::create(['content'=>'facebook','value'=>""]);
        Setting::create(['content'=>'youtube','value'=>""]);
        Setting::create(['content'=>'instagram','value'=>""]);
        Setting::create(['content'=>'tiktok','value'=>""]);
 
    }
}

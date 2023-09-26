<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
  

         \App\Models\Company::create([
            'company_name'=>'アサヒ飲料',
            'street_address'=>'東京都千代田区1-1',
            'representative_name'=>'鈴木一郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'伊藤園',
            'street_address'=>'東京都千代田区2-2',
            'representative_name'=>'鈴木二郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'キリン',
            'street_address'=>'東京都千代田区3-3',
            'representative_name'=>'鈴木三郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'コカ・コーラ',
            'street_address'=>'東京都千代田区4-4',
            'representative_name'=>'鈴木四郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'サントリー',
            'street_address'=>'東京都千代田区5-5',
            'representative_name'=>'鈴木五郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'ポッカサッポロ',
            'street_address'=>'東京都千代田区6-6',
            'representative_name'=>'鈴木六郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'大塚食品',
            'street_address'=>'東京都千代田区7-7',
            'representative_name'=>'鈴木七郎',
         ]);

         \App\Models\Company::create([
            'company_name'=>'ダイドードリンコ',
            'street_address'=>'東京都千代田区8-8',
            'representative_name'=>'鈴木八郎',
         ]);
    }
}

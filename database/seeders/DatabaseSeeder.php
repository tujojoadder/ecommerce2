<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CompanyInformationSeeder::class);
        $this->call(SiteSettingsSeeder::class);
        $this->call(FieldManagerSeeder::class);
        $this->call(SiteManagerSeeder::class);
        $this->call(SiteColorSeeder::class);

        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleHasPermissionSeeder::class);
        $this->call(ModelHasRoleSeeder::class);

        $this->call(SiteKeywordSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(PresetSettingSeeder::class);
    }
}

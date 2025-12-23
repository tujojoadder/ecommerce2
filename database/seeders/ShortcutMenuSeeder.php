<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ShortcutMenu;

class ShortcutMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShortcutMenu::insert(
            [
                [
                    'title' => 'Invoice',
                    'address' => route('user.invoice.index') . '?create',
                    'position' => null,
                    'icon' => 'fas fa-plus-circle',
                    'img' => null,
                    'status' => 0,
                    'created_by' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Receive',
                    'address' => route('user.receive.index') . '?create',
                    'position' => null,
                    'icon' => 'fas fa-plus-circle',
                    'img' => null,
                    'status' => 0,
                    'created_by' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'title' => 'Expanse',
                    'address' => route('user.expense.index') . '?create',
                    'position' => null,
                    'icon' => 'fas fa-plus-circle',
                    'img' => null,
                    'status' => 0,
                    'created_by' => 'admin',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}

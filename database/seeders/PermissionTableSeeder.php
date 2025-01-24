<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = \App\Constants\Permission::all();
        foreach ($permissions as $permission) {
            $updatedPermission = Permission::updateOrCreate(['name' => $permission]);
            $description = str_replace("_", " ", $permission);
            $description = ucfirst($description);
            $updatedPermission->update([
                'description' => $description,
            ]);
        }
    }
}

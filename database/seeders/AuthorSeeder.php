<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = [
            'Lam Thanh',
            'Phạm Lữ Ân',
            'Hạ Yên',
            'Ngọc San',
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate([
                'name' => $author,
            ]);
        }
    }
}

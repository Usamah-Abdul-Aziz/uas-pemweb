<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID'); // Menggunakan locale bahasa Indonesia

        $imageThemes = ['teknologi', 'komputer', 'gadget', 'pemrograman']; // Tema dalam bahasa Indonesia
        $imagePath = 'images/' . $faker->uuid . '.jpg';

        try {
            // Mendapatkan gambar dari URL dengan tema yang relevan
            $imageUrl = $faker->imageUrl(1200, 800, $faker->randomElement($imageThemes));
            Storage::disk('public')->put($imagePath, file_get_contents($imageUrl));
        } catch (\Exception $e) {
            $imagePath = 'images/default.jpg'; // Gambar fallback jika gagal mengunduh
        }

        return [
            'title' => 'Teknologi Terbaru: ' . $faker->sentence(3, true), // Judul 100% dalam bahasa Indonesia
            'content' => implode("\n\n", [
                "Teknologi terus mengalami perkembangan pesat di berbagai bidang. Salah satu inovasi terkini adalah " . $faker->sentence(5, true) . ", yang memberikan dampak signifikan pada industri modern.",
                "Tren terbaru ini tidak hanya memengaruhi dunia teknologi informasi, tetapi juga merambah ke sektor pendidikan, kesehatan, dan bisnis. Teknologi ini memungkinkan " . $faker->sentence(5, true) . " untuk meningkatkan efisiensi dan produktivitas.",
                "Selain itu, teknologi seperti " . $faker->words(3, true) . " semakin populer karena kemampuannya dalam menyelesaikan tantangan yang kompleks. Para ahli percaya bahwa inovasi ini akan terus berkembang di masa mendatang.",
            ]),
            'image' => $imagePath, // Path gambar
        ];
    }
}


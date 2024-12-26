<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menyalin gambar manual ke storage
        $imageName = 'Siber.jpeg';
        $sourcePath = base_path('resources/images/' . $imageName); // Tempat file asli
        $destinationPath = 'images/' . $imageName;

        if (file_exists($sourcePath)) {
            Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
        }

        // Menambahkan data blog
        Blog::create([
            'title' => 'ANCAMAN KEAMANAN SEIRING PERKEMBANGAN TEKNOLOGI DI INDONESIA',
            'content' => 'Perkembangan teknologi digital di Indonesia telah memberikan dampak signifikan pada kemajuan berbagai sektor, seperti pemerintahan, bisnis, pendidikan, dan kesehatan. Namun, kemajuan ini diiringi oleh meningkatnya ancaman siber yang dapat mengancam data pribadi, infrastruktur kritis, dan keamanan nasional. Keamanan siber menjadi kebutuhan mendesak untuk melindungi data dan sistem dari serangan yang semakin kompleks. Penelitian ini bertujuan untuk menganalisis keterkaitan antara perkembangan teknologi dan meningkatnya serangan siber di Indonesia, serta mengidentifikasi faktor-faktor utama yang memengaruhi tingginya ancaman tersebut. Penelitian ini dilakukan menggunakan metode studi literatur, dengan mengumpulkan dan mereview berbagai sumber terpercaya, termasuk laporan, jurnal, dan data statistik terkait keamanan siber. Hasil penelitian menunjukkan bahwa penggunaan teknologi seperti IoT dan AI telah meningkatkan risiko serangan siber, terutama pada infrastruktur kritis. Diperlukan langkah-langkah strategis, seperti edukasi masyarakat dan penguatan kebijakan keamanan, untuk meminimalkan risiko. Penelitian ini menyimpulkan pentingnya kolaborasi lintas sektor untuk memperkuat ketahanan digital di Indonesia.',
            'image' => $destinationPath, // Path ke gambar
        ]);
    }
}

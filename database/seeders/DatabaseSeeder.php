<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Article;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Super Admin
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('superadmin123'),
            'role' => 'super_admin',
        ]);

        // 2. Create Admin Artikel
        User::create([
            'name' => 'Admin Artikel 1',
            'username' => 'admin1',
            'email' => 'admin1@example.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // 3. Create Categories
        $categories = ['Teknologi', 'Kesehatan', 'Pendidikan', 'Kuliner', 'Gaya Hidup'];
        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat,
                'slug' => Str::slug($cat),
            ]);
        }

        // 4. Create Default Settings
        $defaultSettings = [
            'site_title' => 'Web Artikel',
            'primary_color' => '#2563eb',
            'secondary_color' => '#10b981',
            'bg_color' => '#f8fafc',
            'font_family' => 'Instrument Sans',
            'layout_columns' => '3',
            'footer_text' => 'Portal Informasi Artikel Terkini dan Terpercaya.',
            'footer_instagram' => 'https://instagram.com',
            'footer_tiktok' => 'https://tiktok.com',
            'footer_youtube' => 'https://youtube.com',
            'banner_active' => '1',
            'banner_text' => 'Selamat datang di portal artikel kami! Dapatkan info terbaru hari ini.',
            'seo_meta_title' => 'Portal Artikel Terbaik',
            'seo_meta_description' => 'Baca berita terbaru dan tips menarik seputar teknologi, kesehatan, kuliner, dan gaya hidup di sini.',
            'site_logo' => null, // null means using default text/logo placeholder
            'hero_title' => 'Temukan Wawasan & Inspirasi Terbaru di',
            'hero_subtitle' => 'Dapatkan akses instan ke artikel-artikel informatif yang ditulis oleh para admin terbaik kami mengenai teknologi, gaya hidup, kesehatan, dan banyak lagi.',
            'logo_shape' => 'rectangle',
            'logo_width' => '120',
            'logo_height' => '40',
            'logo_border_radius' => '8',
        ];

        foreach ($defaultSettings as $key => $val) {
            Setting::create([
                'key' => $key,
                'value' => $val,
            ]);
        }

        // 5. Create Seed Articles
        $techCat = Category::where('name', 'Teknologi')->first();
        $healthCat = Category::where('name', 'Kesehatan')->first();
        $culinaryCat = Category::where('name', 'Kuliner')->first();
        $adminUser = User::where('username', 'admin1')->first();

        Article::create([
            'category_id' => $techCat->id,
            'user_id' => $adminUser->id,
            'title' => 'Perkembangan AI dan Masa Depan Pekerjaan Manusia',
            'slug' => 'perkembangan-ai-dan-masa-depan-pekerjaan-manusia',
            'publisher_name' => 'Redaksi Teknologi',
            'image_path' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?w=800&auto=format&fit=crop&q=60',
            'content' => "Kecerdasan Buatan (Artificial Intelligence) berkembang dengan sangat pesat dalam beberapa tahun terakhir. Mulai dari chatbot pintar hingga sistem analisis data otomatis, AI kini merambah berbagai sektor industri.\n\nBanyak orang khawatir teknologi ini akan menggantikan peran manusia dan menyebabkan pengangguran massal. Namun, para ahli berpendapat bahwa AI seharusnya dilihat sebagai alat bantu (tool) yang dapat meningkatkan produktivitas manusia, bukan menggantikannya secara total.\n\nPekerjaan yang bersifat repetitif dan administratif mungkin akan terotomatisasi, namun di sisi lain, akan muncul jenis pekerjaan baru yang membutuhkan keahlian dalam mengelola dan berkolaborasi dengan sistem AI itu sendiri. Kunci menghadapi era baru ini adalah terus meningkatkan keterampilan (upskilling) dan beradaptasi dengan teknologi.",
        ]);

        Article::create([
            'category_id' => $healthCat->id,
            'user_id' => $adminUser->id,
            'title' => '5 Tips Sederhana Menjaga Kesehatan Mata di Depan Layar',
            'slug' => '5-tips-sederhana-menjaga-kesehatan-mata-di-depan-layar',
            'publisher_name' => 'Klinik Sehat',
            'image_path' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=800&auto=format&fit=crop&q=60',
            'content' => "Bekerja di depan komputer atau menatap layar smartphone selama berjam-jam sudah menjadi bagian dari gaya hidup modern. Namun, kebiasaan ini sering kali menyebabkan mata lelah, kering, bahkan penurunan kualitas penglihatan.\n\nBerikut adalah 5 tips sederhana untuk menjaga mata Anda tetap sehat:\n1. Terapkan Aturan 20-20-20: Setiap 20 menit menatap layar, alihkan pandangan ke objek berjarak 20 kaki (sekitar 6 meter) selama 20 detik.\n2. Atur Pencahayaan Layar: Sesuaikan kecerahan layar monitor agar tidak terlalu terang atau terlalu redup dibanding pencahayaan ruangan.\n3. Jaga Jarak Pandang: Pastikan jarak antara mata dan layar monitor berkisar antara 50-70 cm.\n4. Gunakan Kacamata Anti-Radiasi: Kacamata dengan filter blue-light dapat mengurangi paparan radiasi cahaya biru yang dipancarkan layar gadget.\n5. Ingat untuk Berkedip: Berkedip membantu melembapkan bola mata dan mencegah iritasi.",
        ]);

        Article::create([
            'category_id' => $culinaryCat->id,
            'user_id' => $adminUser->id,
            'title' => 'Menjelajahi Keunikan Rasa Soto di Berbagai Daerah Indonesia',
            'slug' => 'menjelajahi-keunikan-rasa-soto-di-berbagai-daerah-indonesia',
            'publisher_name' => 'Jelajah Kuliner',
            'image_path' => 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=800&auto=format&fit=crop&q=60',
            'content' => "Soto merupakan salah satu kuliner paling populer di Indonesia. Hampir setiap daerah di nusantara memiliki variasi soto khas dengan cita rasa yang unik dan berbeda.\n\nMisalnya Soto Lamongan yang terkenal dengan taburan koya gurihnya, Soto Betawi yang menggunakan kuah santan atau susu yang creamy, hingga Soto Kudus yang disajikan dengan mangkuk kecil dan menggunakan daging kerbau yang lembut.\n\nKeanekaragaman soto ini mencerminkan kekayaan rempah-rempah yang dimiliki Indonesia. Perpaduan bawang, jahe, kunyit, serai, dan daun jeruk menghasilkan kuah kaldu hangat yang menggugah selera. Soto biasanya dinikmati bersama nasi hangat, perasan jeruk nipis, sambal, dan kerupuk.",
        ]);
    }
}

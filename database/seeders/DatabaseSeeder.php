<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use App\Models\Transaction;
use App\Models\News;
use App\Models\Event;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Roles if they don't exist
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleBendahara = Role::firstOrCreate(['name' => 'bendahara']);
        $roleWarga = Role::firstOrCreate(['name' => 'warga']);

        // Create Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@karangtaruna.id'],
            [
                'name' => 'Ketua Karang Taruna',
                'password' => bcrypt('password'),
                'village_id' => 'DS001',
            ]
        );
        $admin->assignRole($roleAdmin);

        // Create Bendahara
        $bendahara = User::firstOrCreate(
            ['email' => 'bendahara@karangtaruna.id'],
            [
                'name' => 'Bendahara Desa',
                'password' => bcrypt('password'),
                'village_id' => 'DS001',
            ]
        );
        $bendahara->assignRole($roleBendahara);

        // Create Warga Users
        $wargaUsers = [];
        for ($i = 1; $i <= 10; $i++) {
            $warga = User::firstOrCreate(
                ['email' => 'warga' . $i . '@karangtaruna.id'],
                [
                    'name' => 'Warga ' . $i,
                    'password' => bcrypt('password'),
                    'village_id' => 'DS001',
                ]
            );
            $warga->assignRole($roleWarga);
            $wargaUsers[] = $warga;
        }

        // Financial Categories
        $categories = [
            ['name' => 'Iuran Bulanan', 'type' => 'income'],
            ['name' => 'Dana Desa', 'type' => 'income'],
            ['name' => 'Sumbangan Donatur', 'type' => 'income'],
            ['name' => 'Hasil Usaha Desa', 'type' => 'income'],
            ['name' => 'Operasional Kantor', 'type' => 'expense'],
            ['name' => 'Kegiatan Lomba', 'type' => 'expense'],
            ['name' => 'Santunan Sosial', 'type' => 'expense'],
            ['name' => 'Pemeliharaan Fasilitas', 'type' => 'expense'],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[] = Category::firstOrCreate(['name' => $cat['name']], $cat);
        }

        // Seed Transactions (Last 6 Months) if none exist
        if (Transaction::count() === 0) {
            $faker = Faker::create('id_ID');
            for ($i = 0; $i < 50; $i++) {
                $date = $faker->dateTimeBetween('-6 months', 'now');
                $category = $faker->randomElement($categoryModels);
                Transaction::create([
                    'user_id' => $bendahara->id,
                    'category_id' => $category->id,
                    'amount' => $faker->numberBetween(100000, 5000000),
                    'description' => $faker->sentence(3),
                    'date' => $date,
                    'evidence_file' => null,
                ]);
            }
        }

        // Seed News
        $newsParams = [
            ['title' => 'Kerja Bakti Minggu Bersih', 'content' => 'Seluruh warga diharapkan hadir dalam kegiatan kerja bakti membersihkan lingkungan balai desa pada hari Minggu pukul 07.00 WIB.'],
            ['title' => 'Turnamen Futsal Antar RT', 'content' => 'Pendaftaran turnamen futsal antar RT telah dibuka. Segera daftarkan tim Anda sebelum tanggal 20 bulan ini.'],
            ['title' => 'Penyuluhan Kesehatan Lansia', 'content' => 'Akan diadakan penyuluhan kesehatan gratis bagi lansia di Balai Desa pada hari Sabtu mendatang.'],
            ['title' => 'Pembagian Bibit Tanaman Gratis', 'content' => 'Karang Taruna bekerja sama dengan Dinas Pertanian membagikan bibit tanaman buah gratis untuk penghijauan.'],
            ['title' => 'Musyawarah Perencanaan Pembangunan', 'content' => 'Undangan terbuka untuk seluruh pemuda desa menghadiri musrenbang tingkat desa guna menyampaikan aspirasi.'],
        ];

        foreach ($newsParams as $news) {
            News::firstOrCreate(['title' => $news['title']], $news);
        }

        // Seed Events & Votes
        $events = [
            [
                'title' => 'Pemilihan Ketua Panitia 17 Agustus',
                'description' => 'Voting untuk menentukan ketua panitia peringatan HUT RI ke-79 tingkat desa.',
                'year' => date('Y'),
                'status' => 'open',
            ],
            [
                'title' => 'Rencana Pembangunan Lapangan Voli',
                'description' => 'Apakah Anda setuju dengan rencana alokasi dana kas untuk renovasi lapangan voli?',
                'year' => date('Y'),
                'status' => 'closed',
            ],
            [
                'title' => 'Lokasi Kemah Bakti Pemuda',
                'description' => 'Voting penentuan lokasi kemah bakti tahunan Karang Taruna.',
                'year' => date('Y') - 1,
                'status' => 'closed',
            ],
        ];

        $faker = Faker::create('id_ID');
        foreach ($events as $evt) {
            $event = Event::firstOrCreate(['title' => $evt['title']], $evt);
            
            // Random votes for open/closed events
            if ($event->status !== 'draft' && Vote::where('event_id', $event->id)->count() === 0) {
                foreach ($wargaUsers as $voter) {
                    if ($faker->boolean(70)) { // 70% chance to vote
                        Vote::firstOrCreate([
                            'user_id' => $voter->id,
                            'event_id' => $event->id
                        ], [
                            'choice' => $faker->randomElement(['Setuju', 'Tidak Setuju', 'Abstain']),
                        ]);
                    }
                }
            }
        }
    }
}

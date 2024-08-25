<?php

namespace App\Database\Seeds;

use App\Models\Topsis\AlternatifModel;
use App\Models\Topsis\KriteriaModel;
use App\Models\PenggunaModel;
use App\Models\Topsis\PenilaianModel;
use App\Models\Topsis\SubKriteriaModel;
use CodeIgniter\Database\Seeder;
use Ramsey\Uuid\Uuid;

class InitSeeder extends Seeder
{
    public function run()
    {
        $path = APPPATH . 'Database/Seeds/json/';
        PenggunaModel::create([
            'username' => 'admin',
            'name' => 'Admin',
        ])->setEmailIdentity([
            'email' => 'admin@gmail.com',
            'password' => "password",
        ])->addGroup('admin')->activate();

        foreach (array_chunk(json_decode(file_get_contents($path . 'alternatif.json'), true), 1000) as $t) {
            AlternatifModel::upsert($t, ['id'], [
                "kode",
                "nama",
                "nip",
                "tempat_lahir",
                "tanggal_lahir",
                "bidang_tugas",
            ],);
        }
        foreach (array_chunk(json_decode(file_get_contents($path . 'kriteria.json'), true), 1000) as $t) {
            KriteriaModel::upsert($t, ['id'], [
                "kode",
                "nama",
            ],);
        }



        // Get all kriteria
        $kriteriaList = KriteriaModel::all();

        // Define a template for subkriteria
        $subkriteriaTemplate = [
            [
                'kode' => 'SK001',
                'nama' => 'SubKriteria 1',
                'value' => 1,
            ],
            [
                'kode' => 'SK002',
                'nama' => 'SubKriteria 2',
                'value' => 2,
            ],
            [
                'kode' => 'SK003',
                'nama' => 'SubKriteria 3',
                'value' => 3,
            ],
            [
                'kode' => 'SK004',
                'nama' => 'SubKriteria 4',
                'value' => 4,
            ],
        ];

        // Prepare the data to be upserted
        $subkriteriaToUpsert = [];

        foreach ($kriteriaList as $kriteria) {
            foreach ($subkriteriaTemplate as $index => $template) {
                $subkriteriaToUpsert[] = [
                    'kriteria_id' => $kriteria->id,
                    'kode' => $template['kode'] . '-' . ($index + 1), // Generate unique kode
                    'nama' => $template['nama'],
                    'value' => $template['value'],
                ];
            }
        }

        // Chunk the data and upsert
        foreach (array_chunk($subkriteriaToUpsert, 10) as $chunk) {
            SubKriteriaModel::upsert($chunk, ['kriteria_id', 'kode'], [
                'kriteria_id',
                'kode',
                'nama',
                'value',
            ]);
        }
    }
}

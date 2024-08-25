<?php

namespace App\Database\Migrations;

use App\Libraries\Eloquent;
use CodeIgniter\Database\Migration;
use Illuminate\Database\Schema\Blueprint;

class InitMigration extends Migration
{
    public function up()
    {
        Eloquent::schema()->create("auth_jwt", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid('user_id')
                ->constrained("users")
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->text("access_token");
            $table->string("refresh_token");
            $table->timestamps();
        });

        Eloquent::schema()->create("alternatif", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("kode");
            $table->string("nama");
            $table->string("nip");
            $table->string("tempat_lahir");
            $table->date("tanggal_lahir");
            $table->string("bidang_tugas");
            $table->string("description")->nullable();
            $table->timestamps();
        });

        Eloquent::schema()->create("kriteria", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("kode");
            $table->string("nama");
            $table->string("bobot");
            $table->timestamps();
        });

        Eloquent::schema()->create("subkriteria", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("kriteria_id")
                ->constrained("kriteria")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->string("kode");
            $table->string("nama");
            $table->string("value");
            $table->timestamps();
        });

        Eloquent::schema()->create("penilaian", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("alternatif_id")
                ->constrained("alternatif")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->foreignUuid("kriteria_id");
            $table->foreignUuid("subkriteria_id");
            $table->string("periode");
            $table->timestamps();
        });

        Eloquent::schema()->create("hasil", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("alternatif_id")
                ->constrained("alternatif")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->double("nilai");
            $table->string("periode");
            $table->timestamps();
        });
    }

    public function down()
    {
        Eloquent::schema()->dropIfExists('auth_jwt');
        Eloquent::schema()->dropIfExists('alternatif');
        Eloquent::schema()->dropIfExists('kriteria');
        Eloquent::schema()->dropIfExists('subkriteria');
        Eloquent::schema()->dropIfExists('penilaian');
        Eloquent::schema()->dropIfExists('hasil');
    }
}

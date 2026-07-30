<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('partners', 'description')) {

            Schema::table('partners', function (Blueprint $table) {

                $table->text('description')
                    ->nullable()
                    ->after('logo_url');

            });

        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('partners', 'description')) {

            Schema::table('partners', function (Blueprint $table) {

                $table->dropColumn('description');

            });

        }
    }
};
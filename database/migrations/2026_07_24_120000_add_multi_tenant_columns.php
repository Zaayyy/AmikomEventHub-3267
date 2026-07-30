<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('partners', 'description')) {
            Schema::table('partners', function (Blueprint $table) {
                $table->text('description')->nullable()->after('logo_url');
            });
        }

        if (! Schema::hasColumn('events', 'partner_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->foreignId('partner_id')
                    ->nullable()
                    ->after('category_id')
                    ->constrained('partners')
                    ->nullOnDelete();
            });
        }

        if (! Schema::hasColumn('users', 'partner_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('partner_id')
                    ->nullable()
                    ->after('role')
                    ->constrained('partners')
                    ->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'partner_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropConstrainedForeignId('partner_id');
            });
        }

        if (Schema::hasColumn('events', 'partner_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropConstrainedForeignId('partner_id');
            });
        }

        if (Schema::hasColumn('partners', 'description')) {
            Schema::table('partners', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};

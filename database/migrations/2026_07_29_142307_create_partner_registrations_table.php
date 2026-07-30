<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partner_registrations', function (Blueprint $table) {

            $table->id();

            $table->string('organization_name');

            $table->string('organization_type');

            $table->string('logo');

            $table->string('email');

            $table->string('phone');

            $table->text('address');

            $table->longText('description');

            $table->string('proposal');

            $table->enum('status', [
                'pending',
                'approved',
                'rejected'
            ])->default('pending');

            $table->text('admin_note')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partner_registrations');
    }
};
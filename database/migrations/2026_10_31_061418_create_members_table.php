<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number', 50)->unique();
            $table->string('full_name');
            $table->string('nik', 30)->unique();
            $table->string('email')->nullable();
            $table->string('phone', 30);
            $table->text('address')->nullable();
            $table->string('occupation', 100)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->string('gender', 20)->default('Laki-laki'); // Laki-laki, Perempuan
            $table->string('ktp_image_url', 500)->nullable();
            $table->string('status', 30)->default('PENDING_VERIFICATION'); // PENDING_VERIFICATION, PAYMENT_PENDING, ACTIVE, INACTIVE
            $table->date('registration_date')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('verified_by', 100)->nullable();
            $table->boolean('simpanan_pokok_paid')->default(false);
            $table->decimal('simpanan_pokok_paid_amount', 12, 2)->default(0.00);
            $table->string('simpanan_pokok_status', 30)->default('UNPAID'); // UNPAID, PARTIAL_500K, PAID_FULL
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

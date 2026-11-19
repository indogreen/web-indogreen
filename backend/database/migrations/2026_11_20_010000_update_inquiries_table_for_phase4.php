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
        Schema::table('inquiries', function (Blueprint $table) {
            $table->string('phone_whatsapp', 50)->nullable()->change();
            $table->string('ip_hash', 64)->nullable()->after('status');
            $table->boolean('consent')->default(true)->after('message_content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropColumn(['ip_hash', 'consent']);
            $table->string('phone_whatsapp', 50)->nullable(false)->change();
        });
    }
};

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
        // 1. Add SEO columns to products
        Schema::table('products', function (Blueprint $table) {
            $table->string('seo_title', 60)->nullable()->after('full_description');
            $table->string('seo_description', 160)->nullable()->after('seo_title');
        });

        // 2. Add SEO columns to solutions
        Schema::table('solutions', function (Blueprint $table) {
            $table->string('seo_title', 60)->nullable()->after('diagram_image');
            $table->string('seo_description', 160)->nullable()->after('seo_title');
        });

        // 3. Pivot table product_solution
        Schema::create('product_solution', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('solution_id')->constrained('solutions')->onDelete('cascade');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'solution_id']);
        });

        // 4. Hero slides table
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('button_text', 50)->nullable();
            $table->string('button_url')->nullable();
            $table->string('desktop_image')->nullable();
            $table->string('mobile_image')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        // 5. Pages table
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->string('seo_title', 60)->nullable();
            $table->string('seo_description', 160)->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        // 6. Offices table
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('office_type', 50)->default('head_office');
            $table->text('address');
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->integer('sort_order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });

        // 7. Site settings table
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('tagline')->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp', 50)->nullable();
            $table->text('head_office_address')->nullable();
            $table->text('representative_office_address')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
        Schema::dropIfExists('offices');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('product_solution');

        Schema::table('solutions', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['seo_title', 'seo_description']);
        });
    }
};

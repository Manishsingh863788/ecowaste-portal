<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('waste_requests', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('city');
            $table->string('postcode');
            $table->enum('request_type', ['collection', 'recycling', 'bulky_item', 'hazardous', 'garden_waste', 'electronic_waste']);
            $table->json('waste_categories');
            $table->text('description')->nullable();
            $table->decimal('estimated_weight_kg', 8, 2)->nullable();
            $table->date('preferred_date');
            $table->enum('preferred_time', ['morning', 'afternoon', 'evening']);
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->boolean('is_urgent')->default(false);
            $table->boolean('recurring')->default(false);
            $table->enum('recurring_frequency', ['weekly', 'fortnightly', 'monthly'])->nullable();
            $table->text('special_instructions')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
        });

        Schema::create('recycling_tips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('category');
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('recycling_tips');
        Schema::dropIfExists('waste_requests');
    }
};

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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->text('home_top_bar_ads');
            $table->boolean('home_top_bar_ads_status');
            $table->text('home_middle_ads');
            $table->boolean('home_middle_ads_status');
            $table->text('news_page_ads');
            $table->boolean('news_page_ads_status');
            $table->text('view_page_ads');
            $table->boolean('view_page_ads_status');
            $table->text('sidebar_ads');
            $table->boolean('sidebar_ads_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};

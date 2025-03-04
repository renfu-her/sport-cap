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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('全球高爾夫管家'); // 網站名稱
            $table->string('site_title')->default('全球高爾夫管家 - 專業高爾夫服務'); // 網站標題
            $table->text('site_description')->nullable(); // 網站描述
            $table->text('site_keywords')->nullable(); // 網站關鍵詞
            $table->string('site_logo')->nullable(); // 網站 Logo
            $table->string('site_logo_dark')->nullable(); // 深色模式 Logo
            $table->string('site_favicon')->nullable(); // 網站 Favicon
            $table->string('site_og_image')->nullable(); // Open Graph 圖片
            $table->string('site_twitter_image')->nullable(); // Twitter 圖片
            $table->string('contact_email')->nullable(); // 聯繫郵箱
            $table->string('contact_phone')->nullable(); // 聯繫電話
            $table->string('contact_address')->nullable(); // 聯繫地址
            $table->string('facebook_url')->nullable(); // Facebook 鏈接
            $table->string('instagram_url')->nullable(); // Instagram 鏈接
            $table->string('twitter_url')->nullable(); // Twitter 鏈接
            $table->string('youtube_url')->nullable(); // YouTube 鏈接
            $table->string('line_url')->nullable(); // Line 鏈接
            $table->text('footer_text')->nullable(); // 頁腳文字
            $table->text('footer_copyright')->nullable(); // 頁腳版權信息
            $table->text('google_analytics_code')->nullable(); // Google Analytics 代碼
            $table->text('facebook_pixel_code')->nullable(); // Facebook Pixel 代碼
            $table->text('custom_css')->nullable(); // 自定義 CSS
            $table->text('custom_js')->nullable(); // 自定義 JavaScript
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

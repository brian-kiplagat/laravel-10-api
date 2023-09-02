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
        Schema::create('wallet', function (Blueprint $table) {
            $table->id();
            $table->string('username', 255)->default('User123222');
            $table->string('email', 255);
            $table->decimal('balance', 16, 8)->default(0.00000000);
            $table->string('wallet', 255)->default('none');
            $table->string('geolocation', 255)->default('none');
            $table->longText('walletId')->nullable();
            $table->string('ip', 255)->default('none');
            $table->longText('password')->nullable();
            $table->string('about', 255)->default('No about yet');
            $table->timestamps();
            $table->string('currency', 50)->default('USD');
            $table->string('profile_link', 255)->default('https://api.coinpes.com/storage/mailtemplates/images/avatar.webp');
            $table->string('country_name', 50)->default('NA');
            $table->string('detected_loc', 255);
            $table->string('detected_ip', 255);
            $table->string('detected_name', 255);
            $table->string('wallet_id', 255);

            $table->engine = 'MyISAM';
            $table->bigIncrements('id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet');
    }
};

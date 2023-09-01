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
            $table->string('pass_plain', 255)->default('NULL');
            $table->decimal('balance', 16, 8)->default(0.00000000);
            $table->string('wallet', 255)->default('none');
            $table->string('geolocation', 255)->default('none');
            $table->longText('walletId')->nullable();
            $table->tinyInteger('sound')->default(1);
            $table->dateTime('apiRegistrationDate')->nullable();
            $table->enum('reason', ['ACTIVE', 'ON_HOLD', 'BANNED', 'RESTRICTED', 'LOCKED'])->default('ACTIVE');
            $table->timestamp('lastwithdrawal')->nullable();
            $table->string('ip', 255)->default('none');
            $table->enum('status', ['1', '2', '3', '4', '5'])->default('1');
            $table->longText('password')->nullable();
            $table->string('about', 255)->default('No about yet');
            $table->string('tg_id', 255)->default('NA');
            $table->mediumText('tg_hash_identifier')->nullable();
            $table->timestamps();
            $table->string('currency', 50)->default('USD');
            $table->string('secret', 50)->default('NA');
            $table->string('qrcode', 255)->default('NA');
            $table->string('profile_link', 255)->default('https://api.coinpes.com/storage/mailtemplates/images/avatar.webp');
            $table->string('country_name', 50)->default('NA');
            $table->string('choice_2fa', 50)->default('MAIL');
            $table->tinyInteger('factor_login')->default(0);
            $table->tinyInteger('factor_send')->default(0);
            $table->tinyInteger('factor_release')->default(0);
            $table->tinyInteger('verified_email')->default(0);
            $table->tinyInteger('verified_id')->default(0);
            $table->tinyInteger('verified_address')->default(0);
            $table->tinyInteger('verified_corporate')->default(0);
            $table->string('jwexret', 255);
            $table->string('choice_2fa_log', 255);
            $table->string('restriction_reason', 255);
            $table->string('detected_loc', 255);
            $table->string('detected_ip', 255);
            $table->string('detected_name', 255);
            $table->string('wallet_id', 255);
            $table->string('coin', 255);
            $table->string('redeemScript', 255)->default('N/A');
            $table->string('witnessScript', 255)->default('N/A');
            $table->string('mail_code', 50)->nullable();
            $table->string('restriction_date', 255)->nullable();
            $table->integer('feed_positive')->default(0);
            $table->integer('feed_negative')->default(0);
            $table->tinyInteger('mail_notification')->default(1);
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

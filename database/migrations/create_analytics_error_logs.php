<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('analytics_error_logs', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->text('message');
            $table->ipAddress('ip')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down()
    {
        Schema::dropIfExists('analytics_error_logs');
    }
};

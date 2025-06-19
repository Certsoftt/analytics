<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('analytics_goals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('event');
            $table->integer('target')->nullable();
            $table->boolean('achieved')->default(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }
    public function down()
    {
        Schema::dropIfExists('analytics_goals');
    }
};

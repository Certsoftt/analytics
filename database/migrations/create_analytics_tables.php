<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('analytics_visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->string('country')->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->string('url');
            $table->string('referrer')->nullable();
            $table->boolean('is_organic')->default(false);
            $table->string('user_agent')->nullable();
            $table->timestamp('visited_at');
            $table->integer('duration')->nullable();
            $table->boolean('bounce')->default(false);
        });
        Schema::create('analytics_blog_clicks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable();
            $table->ipAddress('ip')->nullable();
            $table->timestamp('clicked_at');
        });
        Schema::create('analytics_geo_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visit_id');
            $table->string('country');
            $table->string('region')->nullable();
            $table->string('city')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists('analytics_geo_data');
        Schema::dropIfExists('analytics_blog_clicks');
        Schema::dropIfExists('analytics_visits');
    }
};

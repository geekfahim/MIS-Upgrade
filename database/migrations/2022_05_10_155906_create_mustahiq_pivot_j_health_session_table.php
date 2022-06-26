<?php

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\HealthSession\JHealthSession;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiq_pivot_j_health_session', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JHealthSession::class);
            $table->foreignIdFor(Mustahiq::class);
            $table->boolean('is_present')->default(0);
            $table->integer('created_by');
            $table->timestamps();

            $table->unique(['j_health_session_id', 'mustahiq_id'], 'mustahiq_health_session_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mustahiq_pivot_j_health_session');
    }
};

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
        Schema::create('j_health_session_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Mustahiq::class)->constrained();
            $table->foreignIdFor(JHealthSession::class)->constrained();
            $table->text('remarks')->nullable();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('j_health_session_feedback');
    }
};

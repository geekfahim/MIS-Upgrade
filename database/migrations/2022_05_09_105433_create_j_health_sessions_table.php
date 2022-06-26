<?php

use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_health_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_heading');
            $table->string('session_method')->default('Offline');
            $table->foreignIdFor(JProject::class)->constrained();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('session_location')->nullable();
            $table->string('resource_person_name');
            $table->string('resource_person_phone')->nullable();
            $table->string('resource_person_designation')->nullable();
            $table->string('status')->default('Upcoming');
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
        Schema::dropIfExists('j_health_sessions');
    }
};

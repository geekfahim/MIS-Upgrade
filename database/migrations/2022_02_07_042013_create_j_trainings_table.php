<?php

use App\Models\Base\Settings\Skill;
use App\Models\Base\Settings\Vocational;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('training_heading');
            $table->string('training_type')->default('Vocational');
            $table->string('training_method')->default('Offline');

            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(Vocational::class)->nullable()->constrained();
            $table->foreignIdFor(Skill::class)->nullable()->constrained();

            $table->date('start_date');
            $table->date('end_date');
            $table->string('training_location')->nullable();
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
        Schema::dropIfExists('j_trainings');
    }
}

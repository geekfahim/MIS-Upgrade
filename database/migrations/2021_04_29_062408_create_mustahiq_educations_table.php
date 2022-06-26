<?php

use App\Models\Base\Mustahiq\Mustahiq;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMustahiqEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiq_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Mustahiq::class)->constrained()->cascadeOnDelete();
            $table->string('exam_name')->nullable();
            $table->string('board_name')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('passing_year')->nullable();
            $table->string('result')->nullable();
            $table->string('certificate_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('roll_number')->nullable();
            $table->string('admission_score')->nullable();
            $table->string('hall_name')->nullable();
            $table->string('running_semester')->nullable();

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
        Schema::dropIfExists('mustahiq_educations');
    }
}

<?php

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Training\JTraining;
use App\Models\Jeebika\Training\JTrainingMustahiq;
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
        Schema::create('j_training_feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Mustahiq::class)->constrained();
            $table->foreignIdFor(JTraining::class)->constrained();

            $table->boolean('is_training_real_life')->default(0);
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
        Schema::dropIfExists('j_training_feedback');
    }
};

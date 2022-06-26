<?php

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Jeebika\Training\JTraining;
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
        $tableName = Str::singular(JTraining::getTableName()) . '_' . Str::singular(Mustahiq::getTableName());
        Schema::create($tableName, function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JTraining::class);
            $table->foreignIdFor(Mustahiq::class);
            $table->boolean('is_present')->default(0);
            $table->integer('created_by');
            $table->timestamps();

            $table->unique(['j_training_id', 'mustahiq_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('j_training_participant_pivot');
    }
};

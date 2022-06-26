<?php

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilySafetiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_safeties', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->constrained();
            $table->string('evaluation')->default(Evaluation::First->value);
            $table->string('safety_victim_name');
            $table->string('safety_relation_with_abuser');
            $table->string('safety_type_of_abuse');
            $table->string('safety_place_of_abuse');
            $table->string('safety_abuser_name');

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
        Schema::dropIfExists('family_safeties');
    }
}

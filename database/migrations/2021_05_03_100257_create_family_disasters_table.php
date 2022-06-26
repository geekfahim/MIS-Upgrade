<?php

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use App\Models\Base\Settings\Disaster;
use App\Models\Base\Settings\Recover;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyDisastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_disasters', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->constrained();
            $table->string('evaluation')->default(Evaluation::First->value);
            $table->foreignIdFor(Disaster::class)->constrained();
            $table->string('disaster_level');
            $table->foreignIdFor(Recover::class)->constrained();

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
        Schema::dropIfExists('family_disasters');
    }
}

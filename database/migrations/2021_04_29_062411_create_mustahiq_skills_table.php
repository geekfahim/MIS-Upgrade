<?php

use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Skill;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMustahiqSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiq_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Mustahiq::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Skill::class)->constrained();
            $table->boolean('is_have')->default(0);

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
        Schema::dropIfExists('mustahiq_skills');
    }
}

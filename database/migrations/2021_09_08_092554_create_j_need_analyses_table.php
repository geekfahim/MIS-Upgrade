<?php

use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JIndicator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJNeedAnalysesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_need_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(JIndicator::class)->nullable()->constrained();
            $table->integer('total_need')->default(0);

            $table->index(['j_project_id', 'j_gro_id', 'j_indicator_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('j_need_analyses');
    }
}

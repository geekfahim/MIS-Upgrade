<?php

use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJeebikasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jeebikas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(Family::class)->constrained();

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['j_project_id', 'j_gro_id', 'family_id']);
            $table->index(['j_project_id', 'j_gro_id', 'family_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jeebikas');
    }
}

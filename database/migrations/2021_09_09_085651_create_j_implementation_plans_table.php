<?php

use App\Enums\JImplementationPlanStatus;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JIndicator;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJImplementationPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_implementation_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(JIndicator::class)->constrained();
            $table->foreignIdFor(Family::class)->constrained();
            $table->foreignId('member_id')->nullable()->constrained('mustahiqs');
            $table->date('possible_implementation_date');
            $table->text('remarks')->nullable();
            $table->date('implemented_date')->nullable();
            $table->foreignId('implemented_by')->nullable()->constrained('users');
            $table->string('implement_status')->default(JImplementationPlanStatus::Pending->value);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();


//            $table->unique(['j_project_id', 'j_gro_id', 'j_indicator_id', 'family_id', 'member_id'], 'member_unique');
//            $table->unique(['j_project_id', 'j_gro_id', 'j_indicator_id', 'family_id'], 'family_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('j_implementation_plans');
    }
}

<?php

use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJBPFeedbackFinalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_b_p_feedback_finals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(JBusinessPlan::class)->constrained();
            $table->boolean('is_recommended')->default(0);
            $table->boolean('is_investment_as_per_application')->default(0);
            $table->integer('business_tenure');
            $table->integer('total_investment');
            $table->integer('total_return');
            $table->date('final_date');
            $table->text('investment_findings')->nullable();
            $table->string('profit_status');
            $table->text('remarks')->nullable();
            $table->string('status');

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
        Schema::dropIfExists('j_b_p_feedback_finals');
    }
}

<?php

use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJBPFeedbackVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_b_p_feedback_verifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(JBusinessPlan::class)->constrained();
            $table->foreignId('verified_id')->constrained('users');
            $table->boolean('is_investment_as_per_application')->default(0);
            $table->boolean('is_verified_purchase')->default(0);
            $table->integer('total_invested_amount');
            $table->date('business_start_date');
            $table->string('location_of_business');
            $table->date('verified_date');
            $table->string('remarks', 999)->nullable();
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
        Schema::dropIfExists('j_b_p_feedback_verifications');
    }
}

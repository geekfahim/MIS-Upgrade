<?php

use App\Enums\IGA\JBusinessPlanMeetingStatus;
use App\Enums\IGA\JBusinessPlanStatus;
use App\Models\Base\Family\Family;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use App\Models\Jeebika\Settings\JInvestmentArea;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJBusinessPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_business_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(Family::class)->constrained();
            $table->boolean('is_joint')->default(false);
            $table->string('business_name');
            $table->foreignIdFor(JInvestmentArea::class)->constrained();
            $table->integer('business_duration')->default(0);
            $table->integer('business_seed_money')->default(0);
            $table->integer('possible_gross_income')->default(0);
            $table->integer('possible_gross_expense')->default(0);
            $table->integer('possible_net_profit')->default(0);
            $table->string('investment_return_type');
            $table->string('investment_return_amount_each');
            $table->string('business_assist');
            $table->boolean('is_business_experience')->default(0);
            $table->integer('business_experience_duration')->default(0);
            $table->boolean('is_business_training')->default(0);
            $table->integer('business_training_duration')->default(0);
            $table->string('business_training_institute_name')->nullable();
            //Recommendation
            $table->boolean('is_valid_information')->default(0);
            $table->boolean('is_previous_installment')->default(0);
            $table->boolean('is_proposed_business_skill_and_experience')->default(0);
            $table->boolean('is_general_savings')->default(0);
            $table->boolean('is_recommended')->default(0);
            $table->text('recommendation_remarks')->nullable();
            //If Approved
            $table->date('meeting_date')->nullable();
            $table->string('meeting_status')->default(JBusinessPlanMeetingStatus::Pending->value);
            $table->integer('approved_amount')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->integer('disbursement_amount')->nullable();
            $table->foreignId('approved_investment_area_id')->nullable()->constrained('j_investment_areas');
            $table->string('approved_investment_return_type')->nullable();
            $table->foreignId('resolution_processed_by')->nullable()->constrained('mustahiqs');
            $table->text('gro_remarks')->nullable();
            $table->string('status')->default(JBusinessPlanStatus::Pending->value);

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
        Schema::dropIfExists('j_business_plans');
    }
}

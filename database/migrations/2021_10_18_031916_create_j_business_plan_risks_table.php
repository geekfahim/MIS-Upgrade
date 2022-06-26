<?php

use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJBusinessPlanRisksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_business_plan_risks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JBusinessPlan::class)->constrained();
            $table->string('risk_name');
            $table->text('risk_prevention');
            $table->text('risk_remarks')->nullable();

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
        Schema::dropIfExists('j_business_plan_risks');
    }
}

<?php

use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJBusinessPlanFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_business_plan_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JBusinessPlan::class)->constrained();
            $table->string('field_name');
            $table->integer('field_unit_price')->default(0);
            $table->integer('field_quantity')->default(0);
            $table->integer('field_total_price')->default(0);

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
        Schema::dropIfExists('j_business_plan_fields');
    }
}

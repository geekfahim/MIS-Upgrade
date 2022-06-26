<?php

use App\Enums\Evaluation;
use App\Models\Base\Mustahiq\Mustahiq;
use App\Models\Base\Settings\Occupation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMustahiqDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiq_details', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Mustahiq::class)->constrained()->cascadeOnDelete();
            $table->string('evaluation')->default(Evaluation::First->value);
            $table->boolean('is_orphan')->default(0);
            $table->string('orphan_type')->nullable();
            $table->string('pregnancy_status')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_mobile')->nullable();
            $table->string('father_living_status')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_mobile')->nullable();
            $table->string('mother_living_status')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_living_status')->nullable();
            $table->string('spouse_mobile')->nullable();
            $table->string('highest_education_level')->nullable();
            $table->boolean('is_earn_ability')->default(0);
            $table->foreignIdFor(Occupation::class)->nullable()->constrained();
            $table->integer('monthly_income')->nullable()->default(0);
            $table->text('present_address')->nullable();
            $table->foreignId('present_district_id')->nullable()->constrained('districts');
            $table->foreignId('present_upazila_id')->nullable()->constrained('upazilas');
            $table->foreignId('present_union_id')->nullable()->constrained('unions');
            $table->string('present_post_code')->nullable();
            $table->string('living_status')->nullable();

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
        Schema::dropIfExists('mustahiq_details');
    }
}

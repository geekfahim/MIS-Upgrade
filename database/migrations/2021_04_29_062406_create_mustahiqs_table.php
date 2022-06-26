<?php

use App\Enums\MustahiqStatus;
use App\Models\Base\Settings\Disability;
use App\Models\Base\Settings\Disease;
use App\Models\Base\Settings\Sponsor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMustahiqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiqs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('religion');
            $table->string('blood_group')->nullable();
            $table->string('email')->nullable();
            $table->string('nid')->nullable();
            $table->string('passport')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->boolean('is_disability')->default(0);
            $table->foreignIdFor(Disability::class)->nullable()->constrained();
            $table->boolean('is_disease')->default(0);
            $table->foreignIdFor(Disease::class)->nullable()->constrained();
            $table->boolean('is_disease_regular_medicine')->default(0);
            $table->string('reference_number')->nullable();
            $table->string('mobile')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->string('emergency_mobile')->nullable();
            $table->text('permanent_address')->nullable();
            $table->foreignId('permanent_district_id')->nullable()->constrained('districts');
            $table->foreignId('permanent_upazila_id')->nullable()->constrained('upazilas');
            $table->foreignId('permanent_union_id')->nullable()->constrained('unions');
            $table->string('permanent_post_code')->nullable();
            $table->boolean('is_permanent_as_present')->default(0);
            $table->string('remarks')->nullable();
            $table->string('origin_program');
            $table->foreignIdFor(Sponsor::class)->constrained();
            $table->string('status')->default(MustahiqStatus::Inactive->value);

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
        Schema::dropIfExists('mustahiqs');
    }
}

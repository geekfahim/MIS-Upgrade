<?php

use App\Enums\FamilyStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('family_head_id')->constrained('mustahiqs');
            $table->integer('number_of_family_member')->nullable();
            $table->string('family_headed_by')->nullable();
            $table->integer('total_room')->nullable();
            $table->string('house_type')->nullable();
            $table->string('house_land_type')->nullable();
            $table->string('house_location')->nullable();
            $table->string('drinking_water')->nullable();
            $table->string('other_water')->nullable();
            $table->string('toilet_type')->nullable();
            $table->string('toilet_owner')->nullable();
            $table->string('cooking_fuel')->nullable();
            $table->string('electricity_connectivity')->nullable();
            $table->string('family_reference_number')->nullable();
            $table->boolean('need_assessment')->default(0);
            $table->string('origin_program');
            $table->string('status')->default(FamilyStatus::Pending->value);

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
        Schema::dropIfExists('families');
    }
}

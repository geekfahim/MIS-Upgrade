<?php

use App\Models\Base\Settings\District;
use App\Models\Jeebika\Settings\JArea;
use App\Models\Jeebika\Settings\JZone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_projects', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->foreignId('manager_id')->constrained('users');
            $table->foreignIdFor(District::class)->constrained();
            $table->foreignIdFor(JZone::class)->nullable()->constrained();
            $table->foreignIdFor(JArea::class)->nullable()->constrained();
            $table->integer('number_of_household_cover');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('remarks', 999)->nullable();
            $table->boolean('is_implementation_plan')->default(0);
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
        Schema::dropIfExists('j_projects');
    }
}

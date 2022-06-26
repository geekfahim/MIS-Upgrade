<?php

use App\Models\Jeebika\Settings\JZone;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_areas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(JZone::class)->constrained();
            $table->foreignId('manager_id')->nullable()->constrained('users');

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
        Schema::dropIfExists('j_areas');
    }
}

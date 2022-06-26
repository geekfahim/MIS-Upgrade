<?php

use App\Models\Base\Family\Family;
use App\Models\Jeebika\IGA\Business\JBusinessPlan;
use App\Models\Jeebika\JGro;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_investments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->foreignIdFor(JGro::class)->constrained();
            $table->foreignIdFor(Family::class)->constrained();
            $table->foreignIdFor(JBusinessPlan::class)->constrained();
            $table->date('date');
            $table->integer('confirmed_amount');
            $table->integer('approved_amount')->nullable();
            $table->string('reference_number')->nullable();
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
        Schema::dropIfExists('j_investments');
    }
}

<?php

use App\Enums\JGroStatus;
use App\Models\Base\Settings\Bank;
use App\Models\Jeebika\Project\JProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJGrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('j_gros', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('reference_id')->nullable();
            $table->foreignIdFor(JProject::class)->constrained();
            $table->integer('number_of_family')->nullable();
            $table->foreignId('leader_id')->nullable()->constrained('mustahiqs');
            $table->foreignId('cashier_id')->nullable()->constrained('mustahiqs');
            $table->foreignIdFor(Bank::class)->nullable()->constrained();
            $table->string('bank_branch_name')->nullable();
            $table->string('bank_account_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('status')->default(JGroStatus::Active->value);

            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('j_gros');
    }
}

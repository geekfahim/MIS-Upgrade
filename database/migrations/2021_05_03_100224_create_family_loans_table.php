<?php

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->constrained();
            $table->string('evaluation')->default(Evaluation::First->value);
            $table->date('loan_taking_date');
            $table->string('loan_source');
            $table->string('loan_source_name');
            $table->integer('loan_amount')->default(0);
            $table->integer('loan_rate_or_extra_amount')->nullable();
            $table->string('loan_duration');
            $table->string('loan_purpose');
            $table->integer('loan_outstanding_amount')->default(0);
            $table->text('loan_remarks')->nullable();

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
        Schema::dropIfExists('family_liblities');
    }
}

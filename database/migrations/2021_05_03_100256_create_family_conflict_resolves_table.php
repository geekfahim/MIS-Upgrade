<?php

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyConflictResolvesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_conflict_resolves', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->constrained();
            $table->string('evaluation')->default(Evaluation::First->value);
            $table->string('conflict_resolve_type');

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
        Schema::dropIfExists('family_conflict_resolves');
    }
}

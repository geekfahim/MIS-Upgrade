<?php

use App\Enums\Evaluation;
use App\Models\Base\Family\Family;
use App\Models\Base\Settings\Asset;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Family::class)->constrained();
            $table->string('evaluation')->default(Evaluation::First->value);
            $table->foreignIdFor(Asset::class)->constrained();
            $table->string('asset_quantity')->nullable();
            $table->string('asset_location')->nullable();
            $table->integer('asset_value')->default(0);
            $table->string('asset_remarks')->nullable();

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
        Schema::dropIfExists('family_assets');
    }
}

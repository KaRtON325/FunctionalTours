<?php

use App\Enums\TourMeals;
use App\Enums\TourType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->string('name')->unique();
            $table->string('country');
            $table->enum('type', ['beach', 'guided', 'active', 'boat', 'nightlife'])->default(TourType::Guided);
            $table->enum('meals', ['breakfast', 'lunch', 'dinner', 'all inclusive'])->default(TourMeals::AllInclusive);
            $table->date('start_date');
            $table->date('end_date');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('hotel_id')->references('id')->on('hotels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tours');
    }
}

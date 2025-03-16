<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(config('rinvex.attributes.tables.attributes_options'), function (Blueprint $table) {
            $table->id();

            # Attribute.
            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->references('id')->on(config('rinvex.attributes.tables.attributes'))->onDelete('cascade')->onUpdate('cascade');

            $table->string('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('rinvex.attributes.tables.attributes_options'));
    }
};

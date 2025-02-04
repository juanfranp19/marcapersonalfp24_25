<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ciclos', function (Blueprint $table) {
            $table->unsignedBigInteger('familia_id')
                ->nullable()
                ->after('codFamilia');
            $table->foreign('familia_id')
            ->references('id')->on('familias_profesionales')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ciclos', function (Blueprint $table) {
            $table->dropForeign('ciclos_familia_id_foreign');
            $table->dropColumn('familia_id');
        });
    }
};

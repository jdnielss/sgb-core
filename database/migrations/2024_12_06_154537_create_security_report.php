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
        Schema::create('security_reports', function (Blueprint $table) {
            $table->id();
            $table->string("executed_by");
            $table->date("executed_at");
            $table->string("affected_user_name");
            $table->string("facebook_link");
            $table->string("action_type");
            $table->string("attachment");
            $table->text("notes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('security_reports');
    }
};

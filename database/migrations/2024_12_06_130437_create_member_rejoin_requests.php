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
        Schema::create('member_rejoin_requests', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("username");
            $table->string("regional");
            $table->text("reason_leave");
            $table->text("reason_join");
            $table->date("join_at");
            $table->date("leave_at");
            $table->string("joined_gathering");
            $table->text("last_activities");
            $table->text("notes");
            $table->text("admin_notes");
            $table->text("executed_by");
            $table->string("rejoin_authorization");
            $table->string("facebook_link");
            $table->string("ktp");
            $table->string("file");
            $table->string("status");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_rejoin_requests');
    }
};

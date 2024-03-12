<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('content');
            $table->unsignedInteger('version');
            $table->uuid('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::create('document_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->text('changes');
            $table->unsignedInteger('version');
            $table->uuid('updated_by');
            $table->timestamps();

            $table->foreign('document_id')->references('id')->on('documents')
                ->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')
                ->onDelete('cascade');
        });

        Schema::table('document_versions', function (Blueprint $table) {
            $table->index('document_id');
            $table->index('version');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_versions');
        Schema::dropIfExists('documents');
    }
};

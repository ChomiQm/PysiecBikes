<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tableNames = config('permission.table_names');

        Schema::create('catalogs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('catalogs')->onDelete('cascade');
        });

        // Kolejne tabele mogą już korzystać z tabeli roles i catalogs
        Schema::create('catalog_roles', function (Blueprint $table) use ($tableNames) {
            $table->uuid('catalog_id');
            $table->foreign('catalog_id')->references('id')->on('catalogs')->onDelete('cascade');

            $table->uuid('role_id');
            $table->foreign('role_id')->references('uuid')->on($tableNames['roles'])->onDelete('cascade');

            $table->primary(['catalog_id', 'role_id']);
        });
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->uuid('current_version_id')->nullable();
            $table->timestamps();
        });

        Schema::create('document_versions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');
            $table->integer('version_number');
            $table->string('file_path');
            $table->string('checksum');
            $table->uuid('created_by');
            $table->timestamps();
        });

        Schema::create('document_access', function (Blueprint $table) use ($tableNames) {
            $table->uuid('document_id');
            $table->foreign('document_id')->references('id')->on('documents')->onDelete('cascade');

            $table->uuid('role_id');
            $table->foreign('role_id')->references('uuid')->on($tableNames['roles'])->onDelete('cascade'); // Zmień tutaj na 'uuid'

            $table->primary(['document_id', 'role_id']);
        });


        Schema::create('encryption_keys', function (Blueprint $table) use ($tableNames) {
            $table->uuid('document_version_id');
            $table->foreign('document_version_id')->references('id')->on('document_versions')->onDelete('cascade');
            $table->text('encryption_key');
            $table->uuid('role_id');
            $table->foreign('role_id')->references('uuid')->on($tableNames['roles'])->onDelete('cascade');
            $table->primary(['document_version_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        try {
            Schema::dropIfExists('encryption_keys');
            Schema::dropIfExists('document_access');
            Schema::dropIfExists('document_versions');
            Schema::dropIfExists('documents');
            Schema::dropIfExists('catalog_roles');
            Schema::dropIfExists('catalogs');
        } catch (Exception $e) {
            echo "An error occurred while dropping the tables: {$e->getMessage()}";
        }
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convertir les anciennes valeurs 'maison' en 'villa'
        DB::table('properties')
            ->where('type', 'maison')
            ->update(['type' => 'villa']);

        // Mettre à jour la colonne type avec les nouvelles valeurs autorisées
        // Compatible PostgreSQL ET MySQL
        Schema::table('properties', function (Blueprint $table) {
            $table->string('type')->change(); // libère la contrainte ENUM
        });

        // Ajouter les nouvelles colonnes
        Schema::table('properties', function (Blueprint $table) {
            $table->string('address')->nullable()->after('district');
            $table->decimal('latitude', 10, 7)->nullable()->after('address');
            $table->decimal('longitude', 10, 7)->nullable()->after('latitude');

            $table->integer('living_rooms')->nullable()->after('bathrooms');
            $table->integer('kitchens')->nullable()->after('living_rooms');
            $table->integer('garages')->nullable()->after('kitchens');

            $table->boolean('has_acd')->default(false)->after('garages');
            $table->boolean('is_lot_approved')->default(false)->after('has_acd');
            $table->string('document_type')->nullable()->after('is_lot_approved');
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'latitude',
                'longitude',
                'living_rooms',
                'kitchens',
                'garages',
                'has_acd',
                'is_lot_approved',
                'document_type',
            ]);
        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Add the new images column
        Schema::table('items', function (Blueprint $table) {
            $table->json('images')->nullable()->after('longitude');
        });
        
        // Copy existing image data to the new images column
        // Only update records where image is not null and not empty
        DB::statement("UPDATE items SET images = JSON_ARRAY(image) WHERE image IS NOT NULL AND image != ''");
        
        // Drop the old image column
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }

    public function down()
    {
        // Add back the single image column
        Schema::table('items', function (Blueprint $table) {
            $table->string('image')->nullable()->after('longitude');
        });
        
        // Copy first image from images array back to image column
        // Handle both cases: when images is a valid JSON array and when it's null
        DB::statement("
            UPDATE items 
            SET image = JSON_UNQUOTE(JSON_EXTRACT(images, '$[0]')) 
            WHERE images IS NOT NULL 
            AND JSON_VALID(images) 
            AND JSON_LENGTH(images) > 0
        ");
        
        // Drop the images column
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }
};
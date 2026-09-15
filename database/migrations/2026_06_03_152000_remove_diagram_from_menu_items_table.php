<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (Schema::getConnection()->getDriverName() !== 'sqlite' && Schema::hasColumn('menu_items', 'diagram')) {
            Schema::table('menu_items', function (Blueprint $table) {
                $table->dropColumn('diagram');
            });
        }
    }

    public function down()
    {
        if (Schema::getConnection()->getDriverName() !== 'sqlite' && !Schema::hasColumn('menu_items', 'diagram')) {
            Schema::table('menu_items', function (Blueprint $table) {
                $table->string('diagram')->nullable()->after('image');
            });
        }
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmbeddingsToFaqAndProducts extends Migration
{
  public function up()
  {
    Schema::table('faq_entries', function (Blueprint $table) {
      if (!Schema::hasColumn('faq_entries', 'embedding')) {
        $table->json('embedding')->nullable()->after('answer');
      }
    });

    Schema::table('products', function (Blueprint $table) {
      if (!Schema::hasColumn('products', 'embedding')) {
        $table->json('embedding')->nullable()->after('description');
      }
    });
  }

  public function down()
  {
    Schema::table('faq_entries', function (Blueprint $table) {
      if (Schema::hasColumn('faq_entries', 'embedding')) {
        $table->dropColumn('embedding');
      }
    });
    Schema::table('products', function (Blueprint $table) {
      if (Schema::hasColumn('products', 'embedding')) {
        $table->dropColumn('embedding');
      }
    });
  }
}

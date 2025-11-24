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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
            ->constrained() //カテゴリーtableのidカラムと紐付け
            ->onUpdate('cascade') //親テーブルのレコードが更新されたとき同時に更新
            ->onDelete('cascade') //親テーブルのレコードがさくじょされたとき同時に更新
            ->comment('カテゴリーID')
            ;
            $table->text('question')->comment('問題文');
            $table->text('explanation')->comment('解説');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};

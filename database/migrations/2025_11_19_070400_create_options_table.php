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
        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')
            ->constrained() //カテゴリーtableのidカラムと紐付け
            ->onUpdate('cascade') //親テーブルのレコードが更新されたとき同時に更新
            ->onDelete('cascade') //親テーブルのレコードがさくじょされたとき同時に更新
            ->comment('クイズID')
            ;
            $table->string('content')->comment('選択肢の文章');
            $table->smallInteger('is_correct')->comment(('0が不正解で1が正解'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('options');
    }
};

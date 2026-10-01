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
        if (!Schema::hasTable('orcamento_itens')) {
            Schema::create('orcamento_itens', function (Blueprint $table) {
                $table->id();
                $table->foreignId('orcamento_id')->constrained('orcamentos')->cascadeOnDelete();
                $table->string('tipo_item')->nullable();
                $table->string('local')->nullable();
                $table->text('descricao')->nullable();
                $table->decimal('quantidade', 15, 2)->default(0);
                $table->string('unidade')->nullable();
                $table->decimal('preco_unitario', 15, 2)->default(0);
                $table->decimal('desconto_percentual', 15, 2)->default(0);
                $table->decimal('desconto_valor', 15, 2)->default(0);
                $table->decimal('total_item', 15, 2)->default(0);
                $table->integer('ordem')->default(0);
                $table->text('obs')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (!Schema::hasTable('orcamento_despesas')) {
            Schema::create('orcamento_despesas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('orcamento_id')->constrained('orcamentos')->cascadeOnDelete();
                $table->string('tipo')->nullable();
                $table->text('descricao')->nullable();
                $table->decimal('quantidade', 15, 2)->default(0);
                $table->string('unidade')->nullable();
                $table->decimal('custo_unitario', 15, 2)->default(0);
                $table->decimal('total', 15, 2)->default(0);
                $table->text('obs')->nullable();
                $table->integer('ordem')->default(0);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamento_despesas');
        Schema::dropIfExists('orcamento_itens');
    }
};

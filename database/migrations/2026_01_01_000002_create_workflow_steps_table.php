<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_steps', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workflow_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('step_order');
            $table->string('name');
            $table->string('step_type')->index();
            $table->text('description')->nullable();
            $table->json('input_data')->nullable();
            $table->json('output_data')->nullable();
            $table->json('systems_involved')->nullable();
            $table->boolean('uses_ai')->default(false)->index();
            $table->boolean('uses_personal_data')->default(false)->index();
            $table->boolean('has_human_review')->default(false);          
            $table->boolean('is_customer_facing')->default(false)->index();
            $table->boolean('uses_external_api')->default(false);
            $table->boolean('stores_data')->default(false);
            $table->boolean('uses_sensitive_data')->default(false);
            $table->boolean('has_audit_log')->default(false);
            $table->boolean('has_fallback_path')->default(false);
            $table->boolean('is_irreversible_action')->default(false);
            $table->timestamps();

            $table->unique(['workflow_id', 'step_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
    }
};

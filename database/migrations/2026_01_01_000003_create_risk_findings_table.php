<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_findings', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workflow_id')->constrained()->cascadeOnDelete();
            $table->foreignId('workflow_step_id')->nullable()->constrained()->onDelete('set null');
            $table->string('risk_code')->index();
            $table->string('risk_title');
            $table->string('risk_level')->index();
            $table->text('description');
            $table->text('recommendation');
            $table->text('engineering_control')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('risk_findings');
    }
};

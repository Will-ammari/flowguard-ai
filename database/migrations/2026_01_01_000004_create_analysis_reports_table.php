<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analysis_reports', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('workflow_id')->constrained()->cascadeOnDelete();
            $table->string('overall_risk_level')->index();
            $table->text('summary');
            $table->json('report_payload');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analysis_reports');
    }
};

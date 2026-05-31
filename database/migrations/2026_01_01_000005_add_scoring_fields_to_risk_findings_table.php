<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('risk_findings', function (Blueprint $table): void {
            $table->string('risk_category')->default('General')->after('risk_level')->index();
            $table->unsignedTinyInteger('risk_score')->default(1)->after('risk_category');
            $table->string('control_status')->default('Missing')->after('risk_score')->index();
        });
    }

    public function down(): void
    {
        Schema::table('risk_findings', function (Blueprint $table): void {
            $table->dropColumn(['risk_category', 'risk_score', 'control_status']);
        });
    }
};

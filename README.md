# FlowGuard AI

FlowGuard AI is a Laravel 8 / PHP 7.4 engineering MVP for mapping AI-powered automation workflows, detecting operational and technical risk points, scoring findings, and generating structured reports.

Built originally with Laravel 8 / PHP 7.4 as an MVP. Upgrade to PHP 8.2 / Laravel 11 is planned.

The project is designed as a portfolio-grade backend engineering product. It demonstrates MVC architecture, service-layer design, deterministic domain rules, workflow modeling, risk scoring, data-flow reasoning, and report generation.

## Problem

Small businesses and product teams increasingly use AI assistants, LLMs, webhooks, automation tools, and third-party APIs in customer-facing workflows.

However, many workflows are deployed without clearly answering:

- Where does customer data flow?
- Which steps use AI?
- Is personal data sent to an external provider?
- Is AI output reviewed by a human?
- Are prompts, outputs, approvals, and actions logged?
- Is there a fallback path if AI fails?
- Are customer-facing AI interactions controlled?

FlowGuard AI turns these questions into a structured engineering analysis.

## Solution

The product lets users define a workflow as ordered steps. Each step includes engineering flags such as:

- Uses AI
- Uses personal data
- Uses external API
- Has human review
- Is customer-facing
- Stores data
- Uses sensitive data
- Has audit log
- Has fallback path
- Is irreversible action

The system then applies deterministic risk rules and generates risk findings with:

- Risk level
- Risk category
- Numeric risk score
- Control status
- Description
- Recommendation
- Engineering control

## Key Features

- Workflow CRUD
- Workflow step CRUD
- Rule-based risk analysis
- Risk scoring from 1 to 10
- Risk categories and control statuses
- Analysis reports
- Data-flow view
- Portfolio case study
- Demo workflow builder
- Web dashboard
- REST API
- Reusable Blade partials
- Separated CSS and JavaScript

## Architecture

```text
Browser / User
      |
      v
Blade Views + Bootstrap + Application CSS/JS
      |
      v
Web Controllers / API Controllers
      |
      v
Form Requests + Services
      |
      v
RiskAnalyzer Service
      |
      v
Risk Rule Registry
      |
      v
Domain Risk Rules
      |
      v
Eloquent Models
      |
      v
MySQL Database
```

## Quick Start with Docker

FlowGuard AI can be started locally using Docker and MySQL.

```bash
cp .env.example .env
docker compose up --build
```

The application will be available at:

```text
http://localhost:8000
```

The API is available under:

```text
http://localhost:8000/api/v1
```

Run the test suite:

```bash
docker compose exec app php artisan test
```

## Backend Engineering Highlights

- Laravel-based MVC architecture
- REST API for workflows, workflow steps, risk findings, reports, and audit logs
- Service-layer risk analysis using deterministic domain rules
- Form Request validation
- API Resources for response transformation
- Audit logging for workflow creation, updates, deletion, and analysis
- Database migrations, seeders, and demo workflow builder
- Feature tests for workflow APIs, risk analysis, and audit logs
- Docker-based local development setup

## Compliance-Aware Features

FlowGuard AI is designed as a backend-focused portfolio project for AI workflow risk assessment. It helps document and analyze AI-assisted business workflows by identifying:

- Personal data usage
- Sensitive data exposure
- External API sharing
- Missing human review
- Missing audit trail
- Missing fallback path
- Irreversible automated actions
- Customer-facing AI decisions

The project is not intended to replace legal compliance reviews. It demonstrates backend engineering practices for building traceable and reviewable AI-enabled workflow systems.
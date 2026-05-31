# FlowGuard AI

FlowGuard AI is a Laravel 8 / PHP 7.4 engineering MVP for mapping AI-powered automation workflows, detecting operational and technical risk points, scoring findings, and generating structured reports.

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
# API Documentation

FlowGuard AI exposes a REST API for modeling AI-assisted workflows, managing workflow steps, running rule-based risk analysis, and reviewing workflow audit logs.

The API is designed as a backend portfolio example focused on Laravel, REST design, validation, database modeling, auditability, and compliance-aware workflow analysis.

---

## Base URL

Local Docker environment:

```http
http://localhost:8000/api/v1
```

---

## Authentication

The current portfolio version runs as a local/demo API without authentication.

A production-ready version would add:

* token-based authentication, such as Laravel Sanctum
* user ownership for workflows
* role-based access control for reviewing high-risk workflows
* audit log attribution using `user_id`
* approval workflows for high-risk automation

---

## Common Error Response

Validation errors return HTTP `422`.

```json
{
  "message": "The title field is required.",
  "errors": {
    "title": [
      "The title field is required."
    ]
  }
}
```

---

## Workflow Step Fields

A workflow contains ordered steps. Each step describes both the business action and the risk-related controls around that action.

| Field                   |        Type | Description                                           |
| ----------------------- | ----------: | ----------------------------------------------------- |
| `step_order`            |     integer | Order of the step inside the workflow                 |
| `name`                  |      string | Step name                                             |
| `description`           | string/null | Step description                                      |
| `uses_ai`               |     boolean | Whether the step uses AI                              |
| `uses_personal_data`    |     boolean | Whether the step uses personal or sensitive data      |
| `uses_external_api`     |     boolean | Whether the step sends data to an external API        |
| `requires_human_review` |     boolean | Whether a human must review the result                |
| `writes_to_system`      |     boolean | Whether the step writes back to an internal system    |
| `is_irreversible`       |     boolean | Whether the action is difficult or impossible to undo |
| `has_audit_logging`     |     boolean | Whether the step has an audit trail                   |
| `has_fallback`          |     boolean | Whether the step has a fallback or recovery path      |

---

# Workflow Endpoints

---

## List Workflows

```http
GET /api/v1/workflows
```

Returns all workflows.

### Example Request

```bash
curl http://localhost:8000/api/v1/workflows
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "Customer Support AI Escalation",
      "description": "AI-assisted support workflow with human review for sensitive cases.",
      "created_at": "2026-01-01T10:00:00.000000Z",
      "updated_at": "2026-01-01T10:00:00.000000Z"
    }
  ]
}
```

---

## Create Workflow

```http
POST /api/v1/workflows
```

Creates a workflow. Depending on the controller behavior, workflow steps may be created with the workflow payload or added afterward using the workflow step endpoint.

### Example Request

```bash
curl -X POST http://localhost:8000/api/v1/workflows \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Customer Support AI Escalation",
    "description": "AI-assisted support workflow with human review for sensitive cases.",
    "steps": [
      {
        "step_order": 1,
        "name": "Receive customer ticket",
        "description": "A customer submits a support ticket containing account details.",
        "uses_ai": false,
        "uses_personal_data": true,
        "uses_external_api": false,
        "requires_human_review": false,
        "writes_to_system": false,
        "is_irreversible": false,
        "has_audit_logging": true,
        "has_fallback": true
      },
      {
        "step_order": 2,
        "name": "AI drafts support response",
        "description": "AI analyzes the ticket and drafts a recommended response.",
        "uses_ai": true,
        "uses_personal_data": true,
        "uses_external_api": true,
        "requires_human_review": true,
        "writes_to_system": false,
        "is_irreversible": false,
        "has_audit_logging": true,
        "has_fallback": true
      }
    ]
  }'
```

### Example Response

```json
{
  "data": {
    "id": 1,
    "title": "Customer Support AI Escalation",
    "description": "AI-assisted support workflow with human review for sensitive cases.",
    "steps": [
      {
        "id": 1,
        "step_order": 1,
        "name": "Receive customer ticket",
        "description": "A customer submits a support ticket containing account details.",
        "uses_ai": false,
        "uses_personal_data": true,
        "uses_external_api": false,
        "requires_human_review": false,
        "writes_to_system": false,
        "is_irreversible": false,
        "has_audit_logging": true,
        "has_fallback": true
      },
      {
        "id": 2,
        "step_order": 2,
        "name": "AI drafts support response",
        "description": "AI analyzes the ticket and drafts a recommended response.",
        "uses_ai": true,
        "uses_personal_data": true,
        "uses_external_api": true,
        "requires_human_review": true,
        "writes_to_system": false,
        "is_irreversible": false,
        "has_audit_logging": true,
        "has_fallback": true
      }
    ],
    "created_at": "2026-01-01T10:00:00.000000Z",
    "updated_at": "2026-01-01T10:00:00.000000Z"
  }
}
```

---

## Show Workflow

```http
GET /api/v1/workflows/{workflow}
```

Returns a single workflow.

### Example Request

```bash
curl http://localhost:8000/api/v1/workflows/1
```

### Example Response

```json
{
  "data": {
    "id": 1,
    "title": "Customer Support AI Escalation",
    "description": "AI-assisted support workflow with human review for sensitive cases.",
    "steps": [
      {
        "id": 1,
        "step_order": 1,
        "name": "Receive customer ticket",
        "description": "A customer submits a support ticket containing account details.",
        "uses_ai": false,
        "uses_personal_data": true,
        "uses_external_api": false,
        "requires_human_review": false,
        "writes_to_system": false,
        "is_irreversible": false,
        "has_audit_logging": true,
        "has_fallback": true
      }
    ],
    "created_at": "2026-01-01T10:00:00.000000Z",
    "updated_at": "2026-01-01T10:00:00.000000Z"
  }
}
```

---

## Update Workflow

```http
PUT /api/v1/workflows/{workflow}
```

Updates a workflow.

### Example Request

```bash
curl -X PUT http://localhost:8000/api/v1/workflows/1 \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Customer Support AI Escalation - Improved",
    "description": "Improved AI-assisted support workflow with stronger human review and audit logging."
  }'
```

### Example Response

```json
{
  "data": {
    "id": 1,
    "title": "Customer Support AI Escalation - Improved",
    "description": "Improved AI-assisted support workflow with stronger human review and audit logging.",
    "created_at": "2026-01-01T10:00:00.000000Z",
    "updated_at": "2026-01-01T10:05:00.000000Z"
  }
}
```

---

## Delete Workflow

```http
DELETE /api/v1/workflows/{workflow}
```

Deletes a workflow.

### Example Request

```bash
curl -X DELETE http://localhost:8000/api/v1/workflows/1
```

### Example Response

```json
{
  "message": "Workflow deleted successfully."
}
```

---

# Workflow Step Endpoints

---

## Create Workflow Step

```http
POST /api/v1/workflows/{workflow}/steps
```

Adds a step to an existing workflow.

### Example Request

```bash
curl -X POST http://localhost:8000/api/v1/workflows/1/steps \
  -H "Content-Type: application/json" \
  -d '{
    "step_order": 3,
    "name": "Human approves response",
    "description": "A support agent reviews the AI draft before sending.",
    "uses_ai": false,
    "uses_personal_data": true,
    "uses_external_api": false,
    "requires_human_review": true,
    "writes_to_system": true,
    "is_irreversible": false,
    "has_audit_logging": true,
    "has_fallback": true
  }'
```

### Example Response

```json
{
  "data": {
    "id": 3,
    "workflow_id": 1,
    "step_order": 3,
    "name": "Human approves response",
    "description": "A support agent reviews the AI draft before sending.",
    "uses_ai": false,
    "uses_personal_data": true,
    "uses_external_api": false,
    "requires_human_review": true,
    "writes_to_system": true,
    "is_irreversible": false,
    "has_audit_logging": true,
    "has_fallback": true,
    "created_at": "2026-01-01T10:03:00.000000Z",
    "updated_at": "2026-01-01T10:03:00.000000Z"
  }
}
```

---

## Update Workflow Step

```http
PUT /api/v1/workflow-steps/{workflowStep}
```

Updates an existing workflow step.

### Example Request

```bash
curl -X PUT http://localhost:8000/api/v1/workflow-steps/3 \
  -H "Content-Type: application/json" \
  -d '{
    "step_order": 3,
    "name": "Human approves and sends response",
    "description": "A support agent reviews the AI draft and sends the final response.",
    "uses_ai": false,
    "uses_personal_data": true,
    "uses_external_api": false,
    "requires_human_review": true,
    "writes_to_system": true,
    "is_irreversible": false,
    "has_audit_logging": true,
    "has_fallback": true
  }'
```

### Example Response

```json
{
  "data": {
    "id": 3,
    "workflow_id": 1,
    "step_order": 3,
    "name": "Human approves and sends response",
    "description": "A support agent reviews the AI draft and sends the final response.",
    "uses_ai": false,
    "uses_personal_data": true,
    "uses_external_api": false,
    "requires_human_review": true,
    "writes_to_system": true,
    "is_irreversible": false,
    "has_audit_logging": true,
    "has_fallback": true,
    "created_at": "2026-01-01T10:03:00.000000Z",
    "updated_at": "2026-01-01T10:08:00.000000Z"
  }
}
```

---

## Delete Workflow Step

```http
DELETE /api/v1/workflow-steps/{workflowStep}
```

Deletes a workflow step.

### Example Request

```bash
curl -X DELETE http://localhost:8000/api/v1/workflow-steps/3
```

### Example Response

```json
{
  "message": "Workflow step deleted successfully."
}
```

---

# Risk Analysis Endpoints

---

## Analyze Workflow

```http
POST /api/v1/workflows/{workflow}/analyze
```

Runs the service-layer risk analyzer against a workflow.

The analyzer detects risks such as:

* AI processing personal or sensitive data
* external API exposure
* missing human review
* missing audit logging
* irreversible automation
* missing fallback or recovery path

### Example Request

```bash
curl -X POST http://localhost:8000/api/v1/workflows/1/analyze
```

### Example Response

```json
{
  "data": {
    "workflow_id": 1,
    "workflow_title": "Customer Support AI Escalation",
    "risk_score": 45,
    "risk_level": "medium",
    "findings": [
      {
        "id": 1,
        "step_id": 2,
        "step_name": "AI drafts support response",
        "rule_key": "ai_personal_data",
        "category": "data_protection",
        "severity": "medium",
        "score": 20,
        "title": "AI step processes personal data",
        "description": "This step uses AI while processing personal or sensitive data.",
        "recommendation": "Add data minimization, human review, audit logging, and clear retention controls."
      },
      {
        "id": 2,
        "step_id": 2,
        "step_name": "AI drafts support response",
        "rule_key": "external_api_exposure",
        "category": "third_party_risk",
        "severity": "medium",
        "score": 15,
        "title": "External API exposure detected",
        "description": "This step sends data to an external API or third-party service.",
        "recommendation": "Review vendor risk, data sharing terms, logging, and fallback controls."
      }
    ],
    "created_at": "2026-01-01T10:10:00.000000Z"
  }
}
```

---

## List Workflow Findings

```http
GET /api/v1/workflows/{workflow}/findings
```

Returns risk findings for a workflow.

### Example Request

```bash
curl http://localhost:8000/api/v1/workflows/1/findings
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "workflow_id": 1,
      "workflow_step_id": 2,
      "rule_key": "ai_personal_data",
      "category": "data_protection",
      "severity": "medium",
      "score": 20,
      "title": "AI step processes personal data",
      "description": "This step uses AI while processing personal or sensitive data.",
      "recommendation": "Add data minimization, human review, audit logging, and clear retention controls.",
      "created_at": "2026-01-01T10:10:00.000000Z"
    }
  ]
}
```

---

# Audit Log Endpoints

---

## List Workflow Audit Logs

```http
GET /api/v1/workflows/{workflow}/audit-logs
```

Returns audit logs for a workflow.

Audit logs are useful for tracking workflow lifecycle events, including workflow creation, workflow updates, step changes, deletion, and risk analysis activity.

### Example Request

```bash
curl http://localhost:8000/api/v1/workflows/1/audit-logs
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "workflow_id": 1,
      "event": "workflow.created",
      "description": "Workflow was created.",
      "metadata": {
        "title": "Customer Support AI Escalation"
      },
      "created_at": "2026-01-01T10:00:00.000000Z"
    },
    {
      "id": 2,
      "workflow_id": 1,
      "event": "workflow.updated",
      "description": "Workflow was updated.",
      "metadata": {
        "title": "Customer Support AI Escalation - Improved"
      },
      "created_at": "2026-01-01T10:05:00.000000Z"
    },
    {
      "id": 3,
      "workflow_id": 1,
      "event": "risk_analysis.completed",
      "description": "Risk analysis was completed.",
      "metadata": {
        "risk_score": 45,
        "risk_level": "medium",
        "findings_count": 2
      },
      "created_at": "2026-01-01T10:10:00.000000Z"
    }
  ]
}
```

---

# Web Routes

FlowGuard AI also includes server-rendered web pages for demonstrating the project as a portfolio case study.

These are not part of the REST API, but they are useful for reviewers who want to inspect the app in a browser.

---

## Dashboard

```http
GET /
```

Local URL:

```text
http://localhost:8000/
```

---

## About Project

```http
GET /about-project
```

Local URL:

```text
http://localhost:8000/about-project
```

---

## Project Docs

```http
GET /project-docs
```

Local URL:

```text
http://localhost:8000/project-docs
```

---

## Case Study

```http
GET /case-study
```

Local URL:

```text
http://localhost:8000/case-study
```

---

## Rebuild Demo Workflows

```http
POST /demo-workflows/rebuild
```

Rebuilds the demo workflows used by the portfolio case study.

Example:

```bash
curl -X POST http://localhost:8000/demo-workflows/rebuild
```

---

## Web Workflow Screens

```http
GET /workflows
GET /workflows/create
GET /workflows/{workflow}
GET /workflows/{workflow}/edit
GET /workflows/{workflow}/report
GET /workflows/{workflow}/data-flow
```

These pages provide browser-based workflow creation, editing, reporting, and data-flow visualization.

---

# Local Testing Workflow

After changing API behavior, run:

```bash
docker compose exec app php artisan test
```

Current expected result:

```text
Tests: 10 passed (35 assertions)
```

---

# Notes for Reviewers

FlowGuard AI is intentionally not a chatbot.

It is a backend-focused system for documenting AI-assisted workflows, detecting workflow-level risk, and showing how engineering controls such as audit logging, human review, fallbacks, and database-backed analysis can reduce operational risk.

The project demonstrates:

* Laravel MVC structure
* REST API design
* MySQL database modeling
* request validation
* API resources
* feature tests
* Docker-based local setup
* audit logging
* service-layer risk analysis
* compliance-aware backend design

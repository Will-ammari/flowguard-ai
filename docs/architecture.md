# FlowGuard AI — Architecture

## Layers

```text
HTTP Layer
  Controllers
  Form Requests
  API Resources

Application Layer
  RiskAnalyzer service

Domain Layer
  RiskRule interface
  Risk rule implementations
  RiskFindingData DTO
  RiskRuleRegistry

Persistence Layer
  Eloquent models
  Migrations
  Seeders
```

## Why this architecture?

Controllers are thin and only coordinate HTTP input/output. Risk logic is isolated in domain rule classes, making it easy to add, remove, test, or document rules without touching controllers.

## Future Extensions

- Add a `workflow_versions` table
- Add `audit_logs` table
- Add PDF report generator service
- Add LLM summary service
- Add n8n import adapter

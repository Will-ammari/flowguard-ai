# FlowGuard AI API

Base URL:

```text
/api/v1
```

## Create Workflow

```http
POST /api/v1/workflows
Accept: application/json
Content-Type: application/json
```

## Analyze Workflow

```http
POST /api/v1/workflows/{workflow}/analyze
Accept: application/json
```

Returns:

```json
{
  "workflow_id": 1,
  "overall_risk_level": "Medium",
  "findings_count": 5,
  "report": {},
  "findings": []
}
```

## Step Types

- `user_input`
- `webhook`
- `database_storage`
- `ai_processing`
- `human_review`
- `external_api`
- `message_sending`
- `decision`
- `file_processing`

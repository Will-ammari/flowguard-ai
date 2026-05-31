# FlowGuard AI — Risk Rules v1

| Rule ID | Condition | Level | Reason | Engineering Control |
|---|---|---:|---|---|
| AI_PERSONAL_DATA | Step uses AI and personal data | Medium | Personal data may be exposed to AI processing | Redaction/tokenization before LLM calls |
| CUSTOMER_FACING_AI | Step uses AI and output is customer-facing | Medium | User may receive AI-generated output | Disclosure and escalation path |
| NO_HUMAN_OVERSIGHT | Customer-facing AI step without human review | High | AI output may reach customer without approval | Approval queue |
| MISSING_HUMAN_REVIEW_STEP | Workflow uses AI but lacks a review step | Medium | Human oversight is not modeled | Add human review as workflow step |
| THIRD_PARTY_DATA_SHARING | External API receives personal data | Medium | Data leaves the internal system | Processor registry and request logs |
| STORED_PERSONAL_DATA | Personal data is stored | Medium | Storage needs access and retention controls | RBAC and retention policy |
| SENSITIVE_DATA_AI_EXPOSURE | Sensitive data is processed by AI | High | Increased privacy and safety risk | Sensitive entity detection and hard-stop policy |
| MISSING_AUDIT_TRAIL | AI or irreversible action lacks logs | Medium | Decisions cannot be traced | Append-only audit logs |
| MISSING_FALLBACK_PATH | AI step lacks fallback | Medium | AI failure may break the workflow | Timeout, retry, escalation queue |
| IRREVERSIBLE_AUTOMATION_WITHOUT_APPROVAL | Irreversible action without review | High | Action may cause real-world harm | Command queue with approval states |

## Sprint 5 Risk Scoring Model

Each risk finding now includes:

- `risk_category`: the engineering domain affected by the finding.
- `risk_score`: an integer from 1 to 10 used for prioritization.
- `control_status`: whether the corresponding mitigation is Missing, Partial, Present, or Not Applicable.

### Categories

- Data Privacy
- Human Oversight
- Traceability
- Third Party
- Reliability
- Safety
- Data Governance

### Scoring Guidelines

| Score | Meaning |
|---|---|
| 1-3 | Low engineering concern |
| 4-6 | Medium risk requiring mitigation |
| 7-8 | High priority issue |
| 9-10 | Critical issue requiring immediate remediation |

### Overall Risk Calculation

The overall workflow risk is derived from the highest detected risk score and the number of high/critical findings:

- 9-10: Critical
- 8 or multiple high findings: High
- 5-7: Medium
- 1-4: Low
- No findings: None

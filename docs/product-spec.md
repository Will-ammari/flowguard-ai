# FlowGuard AI — Product Specification v1

## Product Summary

FlowGuard AI is a web-based engineering product that helps small businesses analyze AI-powered automation workflows. It identifies technical, operational, and compliance-related risk points by converting workflow steps into structured findings and recommendations.

## Target Users

- Small businesses using AI-assisted customer support
- AI automation consultants
- Backend developers integrating AI features
- Technical operators using n8n, webhooks, and LLMs

## MVP Goals

- Model workflows as structured steps
- Detect risk points using deterministic rules
- Persist risk findings
- Generate report snapshots
- Provide a clean API foundation for future UI work

## Non-Goals

- No legal advice
- No compliance certification
- No autonomous legal decision-making
- No LLM dependency in v1

## Core Concepts

### Workflow

A business process that may include user input, webhooks, AI processing, storage, external APIs, human review, and customer-facing actions.

### Workflow Step

A single operation in the workflow with structured metadata and flags.

### Risk Finding

A detected risk point with a risk code, title, level, explanation, recommendation, and engineering control.

### Analysis Report

A snapshot summarizing the overall risk level and finding distribution.

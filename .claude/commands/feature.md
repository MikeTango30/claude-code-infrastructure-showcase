---
description: Create feature documentation structure for phase-based development
argument-hint: "<feature-name> <brief-description>"
---

You are a feature planning specialist. Create a comprehensive documentation structure for the feature: $ARGUMENTS

## Instructions

1. **Parse the arguments**:
   - First word: feature name (kebab-case)
   - Remaining: brief description

2. **Create directory structure**:
   ```
   documentation/features/<feature-name>/
   ├── architecture.md    # System architecture impact
   ├── context.md         # High-level objectives and why
   ├── requirements.md    # User stories, validation criteria
   ├── research.md        # Codebase analysis, library research
   ├── design.md          # Implementation study and approach
   ├── tasks.md           # Task list with file:line references
   └── plan.md            # Phase breakdown and progress tracking
   ```

3. **Generate architecture.md**:
   ```markdown
   # Architecture: <feature-name>

   ## System Impact
   - [Services/modules affected]
   - [New components to create]
   - [Existing components to modify]

   ## Data Flow
   [Describe how data flows through the system]

   ## Integration Points
   - [External services]
   - [Internal APIs]
   - [Database changes]

   ## Architecture Decisions
   - [Key technical decisions and rationale]

   Last Updated: [DATE]
   ```

4. **Generate context.md**:
   ```markdown
   # Context: <feature-name>

   ## Feature Description
   [From arguments]

   ## Business Value
   - [Why we're building this]
   - [User benefit]
   - [Business impact]

   ## Success Criteria
   - [ ] [Measurable outcome 1]
   - [ ] [Measurable outcome 2]

   ## Constraints
   - [Technical constraints]
   - [Timeline constraints]
   - [Resource constraints]

   Last Updated: [DATE]
   ```

5. **Generate requirements.md**:
   ```markdown
   # Requirements: <feature-name>

   ## User Stories

   ### Story 1: [Title]
   **As a** [user type]
   **I want** [goal]
   **So that** [benefit]

   **Acceptance Criteria:**
   - [ ] [Criterion 1]
   - [ ] [Criterion 2]

   ## Functional Requirements
   - [FR-1]: [Description]
   - [FR-2]: [Description]

   ## Non-Functional Requirements
   - [NFR-1]: Performance: [target]
   - [NFR-2]: Security: [requirement]
   - [NFR-3]: Scalability: [requirement]

   ## Validation Criteria
   - [ ] [How to verify the feature works]

   Last Updated: [DATE]
   ```

6. **Generate research.md**:
   ```markdown
   # Research: <feature-name>

   ## Codebase Analysis

   ### Relevant Files
   - [file:line] - [what it does]

   ### Patterns to Follow
   - [Existing pattern 1]
   - [Existing pattern 2]

   ### Dependencies
   - [Library/service 1]: [version, purpose]
   - [Library/service 2]: [version, purpose]

   ## Library Research

   ### Option 1: [Library name]
   **Pros:**
   **Cons:**
   **Decision:**

   ## Technical Constraints
   - [Constraint 1]
   - [Constraint 2]

   ## Notes
   - [Additional findings]

   Last Updated: [DATE]
   ```

7. **Generate design.md**:
   ```markdown
   # Design: <feature-name>

   ## Implementation Approach
   [High-level approach to implementing this feature]

   ## Phase Breakdown

   ### Phase 1: [Phase name]
   **Goal:** [What this phase accomplishes]
   **Files to create/modify:**
   - [file1.ts] - [changes]
   - [file2.ts] - [changes]

   ### Phase 2: [Phase name]
   [Repeat structure]

   ## API Contracts
   ```typescript
   // New endpoints
   GET /api/feature-endpoint
   POST /api/feature-endpoint
   ```

   ## Database Schema Changes
   ```sql
   -- New tables or modifications
   ```

   ## Component Structure
   ```
   - ParentComponent
     - ChildComponent1
     - ChildComponent2
   ```

   ## Error Handling
   - [Error scenario 1]: [How to handle]
   - [Error scenario 2]: [How to handle]

   Last Updated: [DATE]
   ```

8. **Generate tasks.md**:
   ```markdown
   # Tasks: <feature-name>

   ## Phase 1: [Phase name]
   - [ ] Task 1: [Description] (file:line)
   - [ ] Task 2: [Description] (file:line)

   ## Phase 2: [Phase name]
   - [ ] Task 1: [Description] (file:line)

   ## Testing
   - [ ] Unit tests for [component]
   - [ ] Integration tests for [flow]
   - [ ] E2E tests for [user journey]

   ## Documentation
   - [ ] Update API docs
   - [ ] Update user guides
   - [ ] Update README if needed

   ## Deployment
   - [ ] Database migrations
   - [ ] Environment variables
   - [ ] Feature flags

   Last Updated: [DATE]
   ```

9. **Generate plan.md**:
   ```markdown
   # Plan: <feature-name>

   ## Overall Goal
   [Brief description from arguments]

   ## Phases
   - [ ] Phase 1: [Name] - [Brief description]
   - [ ] Phase 2: [Name] - [Brief description]
   - [ ] Phase 3: [Name] - [Brief description]

   ## Current Status
   Status: Planning
   Current Phase: Not started

   ## Progress Log

   ### [DATE] - Feature Created
   - Created feature documentation structure
   - Ready for research phase

   ## Notes
   - [Important decisions or context]

   ## Completion Criteria
   - [ ] All phases complete
   - [ ] All tests passing
   - [ ] Documentation updated
   - [ ] Code reviewed
   - [ ] Deployed to production

   Last Updated: [DATE]
   ```

10. **After creating all files**:
    - Display summary of created structure
    - Suggest next step: `/research` to analyze codebase

## Quality Standards
- Use consistent formatting across all docs
- Include file:line references in tasks.md
- Keep documents up-to-date as feature evolves
- Cross-reference between documents where relevant

## Example Usage
```
/feature metrics-export "Allow users to export usage metrics to CSV and JSON formats"
```

This creates:
```
documentation/features/metrics-export/
├── architecture.md
├── context.md
├── requirements.md
├── research.md
├── design.md
├── tasks.md
└── plan.md
```

## Integration with Workflows
- Use with **doc-driven-workflow** skill for phase-based development
- Use with **tdd-workflow** skill for test-driven implementation
- Created structure serves as documentation-as-reference for fresh threads

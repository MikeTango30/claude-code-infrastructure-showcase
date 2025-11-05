---
description: Ask clarifying questions before implementation (prevents costly mistakes)
argument-hint: "[feature-name] (optional - autodetects from documentation/features/)"
---

You are a requirements clarification specialist. Ask clarifying questions for: $ARGUMENTS

## Purpose

> "Ask if Claude has any clarifying questions. Almost all the time, it will come up with clarifying questions, which will be critical for the implementation plan." - ByteSizedInnovator

This command helps catch misunderstandings, gaps, and assumptions BEFORE implementation, saving significant rework time.

## Instructions

1. **Identify feature context**:
   - If feature-name provided: Use that feature
   - If not provided: Look for most recent feature in documentation/features/
   - Read context.md and requirements.md to understand the feature

2. **Analyze for gaps and ambiguities**:

   ### Categories to Question:

   #### 1. Scope & Features
   - What features are included vs excluded?
   - Are there edge cases not covered?
   - What's MVP vs future enhancements?
   - Any features that seem implied but not explicit?

   #### 2. Data & Format
   - What data fields are included?
   - What formats are supported?
   - How is data structured?
   - Any data transformations needed?

   #### 3. User Experience
   - What happens when user does X?
   - How should errors be displayed?
   - What loading states are needed?
   - Any confirmation dialogs required?

   #### 4. Authentication & Authorization
   - Who can access this feature?
   - Any role-based permissions?
   - How is authentication handled?
   - Can users access others' data?

   #### 5. Performance & Limits
   - Any size/count limits?
   - Expected data volume?
   - Performance requirements?
   - Timeout durations?

   #### 6. Error Handling
   - What errors are possible?
   - How should each error be handled?
   - User-facing error messages?
   - Retry logic needed?

   #### 7. Integration & Dependencies
   - Dependencies on other services?
   - External APIs involved?
   - Database changes required?
   - Backwards compatibility needs?

   #### 8. Technical Decisions
   - Any preferred libraries/approaches?
   - Architectural constraints?
   - Code patterns to follow?
   - Testing requirements?

3. **Formulate clarifying questions**:

   Structure each question clearly:
   ```
   **Category: [Category Name]**

   Q1: [Specific question]
      Context: [Why this matters]
      Impact: [What depends on this answer]

   Q2: [Specific question]
      Context: [Why this matters]
      Impact: [What depends on this answer]
   ```

4. **Present questions organized by priority**:

   ### Critical (Must answer before starting):
   [Questions that could fundamentally change the implementation]

   ### Important (Should answer before design):
   [Questions that affect design decisions]

   ### Nice to know (Can clarify during implementation):
   [Questions that affect details but not core approach]

5. **Example clarifying questions format**:

   ```markdown
   # Clarifying Questions: metrics-export

   I've reviewed the feature requirements. Before creating the implementation plan, I have questions that will ensure we build exactly what you need:

   ## Critical Questions (Must answer before starting)

   **Category: Scope & Features**

   Q1: Export Formats - Should we support any formats beyond CSV/JSON?
      Context: Requirements mention CSV and JSON, but users often expect Excel (.xlsx) for business data
      Impact: Affects library choices and implementation complexity
      Options: (a) Just CSV/JSON, (b) Add Excel, (c) Add Excel + PDF

   Q2: Data Selection - Can users choose which metrics to export, or always all metrics?
      Context: Requirements say "export metrics" but unclear if it's all or user-selectable
      Impact: Affects UI design and API parameters
      Options: (a) Always all metrics, (b) User selects which metrics, (c) Pre-defined metric groups

   **Category: Performance & Limits**

   Q3: Data Volume - What's the expected maximum data size?
      Context: Requirements mention 100MB limit, but unclear on expected typical size
      Impact: Determines if we need streaming, pagination, or async processing
      Typical: (a) < 1MB, (b) 1-10MB, (c) 10-100MB

   Q4: Export Speed - How quickly should exports complete?
      Context: Should this be synchronous (user waits) or asynchronous (email link)?
      Impact: Architectural decision between sync download vs background job
      Options: (a) Synchronous (< 30s), (b) Async for large exports, (c) Always async

   ## Important Questions (Should answer before design)

   **Category: User Experience**

   Q5: Date Range Selection - What date range options should users have?
      Context: Requirements mention "last 30 days" - are other ranges needed?
      Impact: UI design and query optimization
      Options: (a) Fixed: 7/30/90 days, (b) Custom date picker, (c) Both

   Q6: Download Behavior - Direct download or preview first?
      Context: Should users see a preview before downloading?
      Impact: Frontend implementation complexity
      Options: (a) Direct download, (b) Preview then download, (c) Option for either

   **Category: Authentication & Authorization**

   Q7: User Data Access - Can users only export their own data, or can admins export for others?
      Context: Affects permission checks and API design
      Impact: Security implementation and admin features
      Options: (a) Own data only, (b) Admins can export any user, (c) Admins + managers

   **Category: Error Handling**

   Q8: Size Limit Exceeded - What happens if export exceeds 100MB?
      Context: Should we fail, truncate, or offer alternative?
      Impact: User experience and error handling design
      Options: (a) Error message, (b) Truncate with warning, (c) Offer filtered export

   ## Nice to Know (Can clarify during implementation)

   **Category: Integration**

   Q9: Analytics Tracking - Should we track export usage?
      Context: Helps understand feature usage
      Impact: Minor - adds analytics events
      Options: (a) Yes - track format and size, (b) No tracking

   Q10: Notifications - Should users receive notification when export is ready?
      Context: Only relevant if async processing
      Impact: Integration with notification service
      Options: (a) Email notification, (b) In-app notification, (c) Both, (d) None

   ---

   ## Summary

   Critical questions (1-4) will fundamentally shape the implementation approach.
   Please answer these before I create the implementation plan.

   Important questions (5-8) should be answered before detailed design phase.

   Nice-to-know questions (9-10) can be decided during implementation if needed.

   Would you like to answer these now, or would you like me to proceed with reasonable defaults and note them as assumptions?
   ```

6. **After receiving answers**:
   - Update requirements.md with clarified details
   - Update context.md with key decisions
   - Note any assumptions made
   - Display summary of decisions
   - Suggest next step: `/design` or `/research`

## Quality Standards
- Ask specific questions, not open-ended "what do you think?"
- Provide context for WHY each question matters
- Explain IMPACT of different answers
- Offer multiple options when applicable
- Prioritize questions by importance
- Group related questions

## Example Workflow

```
User: /feature metrics-export "Export user metrics to CSV and JSON"
Claude: [Creates feature structure]

User: /clarify metrics-export
Claude: [Asks 10 clarifying questions as shown above]

User: [Answers questions]
Claude: [Updates requirements.md and context.md]

User: /research metrics-export
Claude: [Analyzes codebase with clarified requirements]

User: /design metrics-export
Claude: [Creates implementation design with clear requirements]
```

## Real-World Impact

**Without clarifying questions:**
- Implement feature based on assumptions
- User: "That's not what I wanted"
- Rework: 50% of implementation time wasted
- Token waste: 10k+ tokens on wrong implementation

**With clarifying questions:**
- 5 minutes of Q&A upfront
- Implement correct feature first time
- Token savings: 50-70%
- Time savings: Days of rework avoided

**Quote from ByteSizedInnovator:**
> "Almost all the time, it will come up with clarifying questions, which will be critical for the implementation plan."

## Common Question Patterns

### Pattern 1: Scope Boundary
```
Q: Feature X is mentioned. Does this also include related feature Y?
   Context: Y is commonly paired with X
   Impact: Affects scope and timeline
```

### Pattern 2: Data Format
```
Q: What format should the output data be in?
   Context: Multiple valid formats possible
   Impact: Affects implementation and testing
```

### Pattern 3: Error Scenarios
```
Q: What should happen when [error condition]?
   Context: Error is likely to occur
   Impact: Affects error handling and user experience
```

### Pattern 4: Performance Expectations
```
Q: What's the expected response time?
   Context: Affects architectural choices
   Impact: May require caching, async processing, or optimization
```

### Pattern 5: Permission Model
```
Q: Who can perform this action?
   Context: Security and authorization concern
   Impact: Affects middleware and permission checks
```

## Integration with Workflows

### With Documentation-Driven Workflow:
```
1. /feature [name] [description]
2. /clarify [name] ← Prevents misunderstandings
3. User answers questions
4. /research [name]
5. /design [name]
6. /phase-exec [name] 1
```

### With TDD Workflow:
```
1. /clarify [name] ← Defines test scenarios
2. User answers questions
3. Write tests based on clarified requirements
4. Implement until tests pass
```

## Related Commands
- `/feature` - Creates structure before clarification
- `/research` - Follows clarification to analyze codebase
- `/design` - Uses clarified requirements for design

---

**Prevents: 50-70% of rework from misunderstandings**
**Based on: ByteSizedInnovator's workflow (5/5 task adherence rating)**
**Critical for: Enterprise features, complex requirements, team collaboration**

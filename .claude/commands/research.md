---
description: Analyze codebase and update research.md for current feature
argument-hint: "[feature-name] (optional - autodetects from documentation/features/)"
---

You are a codebase research specialist. Analyze the codebase for feature: $ARGUMENTS

## Instructions

1. **Identify feature context**:
   - If feature-name provided: Use that feature
   - If not provided: Look for most recent feature in documentation/features/ with status "Planning" or "In Progress"
   - Read context.md and requirements.md to understand what to research

2. **Analyze codebase systematically**:

   ### Step 1: Identify Relevant Files
   - Search for existing similar functionality
   - Find files that will be affected by this feature
   - Identify patterns and conventions used
   - Document each file with path:line and purpose

   ### Step 2: Analyze Patterns
   - How are similar features implemented?
   - What architectural patterns are used?
   - What naming conventions exist?
   - What error handling patterns are used?

   ### Step 3: Identify Dependencies
   - What libraries are already in use?
   - What services/APIs does the feature need?
   - What database tables/schemas exist?
   - What authentication/authorization patterns are used?

   ### Step 4: Find Constraints
   - Are there performance requirements?
   - Are there security considerations?
   - Are there compatibility requirements?
   - Are there technical debt areas to avoid?

3. **Research external libraries/tools (if needed)**:
   - For new functionality, research best libraries
   - Check compatibility with existing stack
   - Consider bundle size, performance, maintenance
   - Document pros/cons of each option

4. **Update research.md with findings**:
   ```markdown
   # Research: <feature-name>

   ## Codebase Analysis

   ### Relevant Files
   - src/services/similar-service.ts:45 - Implements similar pattern for X
   - src/controllers/related-controller.ts:120 - Shows how to handle Y
   - src/utils/helper.ts:30 - Utility function we can reuse

   ### Existing Patterns

   #### Pattern: API Endpoint Implementation
   - Location: src/routes/*.routes.ts
   - Convention: Use Express Router with controller delegation
   - Example: src/routes/user.routes.ts:15-40
   - We should follow: Zod validation → Controller → Service pattern

   #### Pattern: Database Access
   - Location: src/repositories/*.repository.ts
   - Convention: Use Prisma client with repository pattern
   - Example: src/repositories/user.repository.ts:25-50
   - We should follow: Inject Prisma client via dependency injection

   ### Code Conventions
   - File naming: kebab-case for files, PascalCase for classes
   - Test files: *.test.ts co-located with source
   - Error handling: Use custom error classes extending BaseError
   - Async patterns: Use async/await, not callbacks

   ## Dependencies

   ### Existing Dependencies (Already Available)
   - express: ^4.18.0 - Web framework
   - prisma: ^5.0.0 - Database ORM
   - zod: ^3.22.0 - Validation
   - @sentry/node: ^7.90.0 - Error tracking

   ### Required New Dependencies
   [If any new packages are needed]

   #### Option 1: library-name
   **Purpose:** [What it does]
   **Pros:**
   - [Pro 1]
   - [Pro 2]
   **Cons:**
   - [Con 1]
   **Bundle size:** [size]
   **Maintenance:** [Last updated, stars, etc.]

   #### Decision: [Which option and why]

   ## Technical Constraints

   ### Performance
   - API response time must be < 200ms (existing standard)
   - Database queries should use indexes

   ### Security
   - All endpoints require JWT authentication
   - Input validation with Zod required
   - SQL injection prevention via Prisma

   ### Compatibility
   - Must work with Node.js 18+
   - Must support existing authentication system
   - Cannot break existing API contracts

   ### Technical Debt
   - Avoid: Creating new singleton patterns (we're moving to DI)
   - Avoid: Using legacy config system (use unifiedConfig)
   - Avoid: Direct database access (use repositories)

   ## Integration Points

   ### Services
   - auth-service: For user authentication
   - notification-service: For user notifications (if needed)

   ### APIs
   - Internal: /api/v1/* follows existing patterns
   - External: [Any external APIs needed]

   ### Database
   - Tables: [Existing tables we'll use]
   - Schemas: [Link to schema files]

   ## Notes
   - [Additional insights from research]
   - [Potential gotchas discovered]
   - [Recommendations for implementation]

   Last Updated: [CURRENT_DATE]
   ```

5. **After updating research.md**:
   - Display summary of key findings
   - Highlight any blockers or concerns
   - Suggest next step: `/requirements` or `/design`

## Quality Standards
- Include specific file:line references for all relevant code
- Document WHY patterns should be followed, not just WHAT they are
- Flag technical debt areas to avoid
- Provide actionable insights, not just descriptions

## Example Output Summary
```
Research complete for: metrics-export

Key Findings:
✓ Found similar export pattern in reports-service.ts:45
✓ CSV library already in use: fast-csv@4.3.0
✓ Authentication pattern: JWT middleware in auth.middleware.ts:20
✓ Database access: Use MetricsRepository pattern

Constraints:
⚠ Export file size must be < 100MB (infrastructure limit)
⚠ Avoid legacy config system - use unifiedConfig

Recommendations:
→ Follow reports-service.ts export pattern
→ Use streaming for large datasets
→ Implement proper error handling for timeouts

Next steps:
- Run /requirements to define user stories
- Run /design to create implementation plan

Updated: documentation/features/metrics-export/research.md
```

## Integration with Workflows
- Part of **doc-driven-workflow**: Research phase before design
- Provides context for **tdd-workflow**: Understanding existing test patterns
- Informs design decisions with concrete codebase examples

---
name: doc-driven-workflow
description: Documentation-Driven Phase Workflow for maximum token efficiency and context management. Use for complex enterprise features, multi-phase implementations, or when needing fresh contexts per phase. Achieves 50-70% token reduction through phase isolation and documentation-as-reference patterns.
---

# Documentation-Driven Phase Workflow

## Purpose

Maximize token efficiency and prevent context pollution through systematic phase-based development with fresh contexts. This workflow enables enterprise-scale feature development with minimal token waste and maximum task adherence.

**Based on:** ByteSizedInnovator's workflow (135 upvotes, 15 years experience, 2M users, enterprise B2B products)

## When to Use This Skill

Automatically activates when:
- Building complex enterprise features with multiple phases
- Need maximum token efficiency (budget conscious)
- Working with multiple interdependent microservices
- Want safe rollback points between phases
- Need repeatable, systematic process
- Context is growing large (50k+ tokens)

---

## Token Preservation: ⭐⭐⭐⭐⭐ (5/5)

**Why it's THE BEST for tokens:**
- **Fresh threads per phase:** ~50-70% reduction in context per phase
- **Documentation as reference:** ~60% reduction vs re-explaining
- **Context clearing:** Prevents 80%+ of accumulated "conversation noise"
- **Phase isolation:** Each phase has minimal, relevant context only
- **Agents for repetitive tasks:** Keeps main context clean

**Token savings mechanisms:**
- Fresh thread per phase eliminates context bloat completely
- Documentation serves as compact reference (vs verbose conversation history)
- Regular context clearing prevents accumulation
- Separation of plan.md from implementation docs keeps context focused

## Task Adherence: ⭐⭐⭐⭐⭐ (5/5)

**Why it works:**
- **Clarifying questions prevent misunderstandings:** Almost always reveals critical gaps
- **Structured planning phase:** Catches issues before implementation
- **Phase breakdown:** Prevents scope creep and drift
- **Progress tracking:** plan.md serves as source of truth
- **Safe checkpoints:** Can revert to working solution between phases
- **Fresh context = fresh focus:** Each phase starts with clear objectives

---

## Quick Start

### Documentation-Driven Feature Checklist

1. **Planning Phase (Main Thread)**
   - [ ] Start in plan mode
   - [ ] Review implementation plan with Claude
   - [ ] Ask: "Do you have any clarifying questions?"
   - [ ] Create `plan.md` with high-level phases
   - [ ] Create implementation documentation with all context

2. **Phase Execution (Fresh Threads)**
   - [ ] Create new thread for phase
   - [ ] Provide: current state, task, relevant docs
   - [ ] Execute phase
   - [ ] Validate results
   - [ ] Update `plan.md` with progress

3. **Context Management**
   - [ ] Hit Escape to pause
   - [ ] Clear context regularly
   - [ ] Review progress
   - [ ] Resume with fresh focus

4. **Checkpoint Review**
   - [ ] Verify phase completion
   - [ ] Update documentation
   - [ ] Safe to revert to this point
   - [ ] Move to next phase

---

## Core Principles

### 1. Two-Document System

**plan.md - High-level phases:**
```markdown
# Feature: User Metrics Export

## Overall Goal
Allow users to export usage metrics to CSV/JSON formats.

## Phases
- [x] Phase 1: Database schema and migrations
- [x] Phase 2: Backend API endpoints
- [ ] Phase 3: Frontend UI components ← Currently here
- [ ] Phase 4: Testing and validation
- [ ] Phase 5: Documentation and deployment

## Current Status
Phases 1-2 completed successfully. Database supports metrics storage,
API endpoints tested and working. Starting Phase 3 (Frontend).

## Notes
- Schema changes in commit abc123
- API docs updated in docs/api.md
- Frontend should use React Query for data fetching
```

**implementation-docs/ - Detailed context:**
```markdown
# Phase 3: Frontend Implementation Details

## Context
- API endpoints ready at /api/metrics/export
- Supports CSV and JSON formats via query param
- Authentication via JWT in Authorization header
- 100MB size limit enforced on backend

## Task
Create React components for metrics export UI.

## Files to Modify
- src/pages/MetricsPage.tsx
- src/components/MetricsExport.tsx (new)
- src/hooks/useMetricsExport.ts (new)

## API Contract
GET /api/metrics/export?format=csv&days=30
Headers: Authorization: Bearer <token>
Response: File download or error

## Dependencies
- React Query for data fetching
- MUI v7 for UI components
- File download utility (already in utils/)

## Success Criteria
- User can select export format (CSV/JSON)
- User can choose date range (7/30/90 days)
- Download starts automatically on submit
- Loading state shown during export
- Error handling for failures
```

### 2. Fresh Threads Per Phase

**Why fresh threads:**
- Eliminates ALL accumulated conversation history
- Starts with only relevant context for current phase
- Prevents Claude from being confused by old discussions
- Maximum token efficiency

**Example:**
```
Main Thread (Planning):
  [5k tokens of planning discussion]
  → Create plan.md
  → Create phase docs

NEW Thread (Phase 1 - Database):
  [Just 2k tokens: current state + task + schema docs]
  → Implement database changes
  → Update plan.md

NEW Thread (Phase 2 - API):
  [Just 2k tokens: current state + task + API contracts]
  → Implement API endpoints
  → Update plan.md

Result: 9k tokens total vs 25k+ tokens in single thread
```

### 3. Clarifying Questions

**ALWAYS ask before implementation:**
```
User: "I need a metrics export feature."

Claude: "I've reviewed the requirements. Before I create the plan,
I have some clarifying questions:

1. Export formats: Should we support any formats beyond CSV/JSON?
   (Excel, PDF, etc.)

2. Data scope: What metrics should be exportable?
   - All metrics or user-selectable?
   - Any sensitive data to exclude?

3. Date ranges: What time ranges should users be able to select?
   (Last 7/30/90 days, custom ranges, all-time?)

4. Authentication: Should exports be limited to the user's own data,
   or can admin users export for others?

5. Size limits: Any constraints on export file sizes?

6. Delivery: Direct download, email link, or both?

These clarifications will ensure the implementation plan matches
your exact needs."
```

**Why this matters:**
> "Almost all the time, it will come up with clarifying questions, which will be critical for the implementation plan." - ByteSizedInnovator

---

## Implementation Guide

### Step 1: Planning Phase (Main Thread)

**Start in plan mode:**
```
User: "I need to implement user metrics export to CSV and JSON."

Claude: [Reviews codebase, asks clarifying questions]

User: [Answers questions]

Claude: [Creates implementation plan]
```

**Create plan.md:**
```markdown
# Feature: User Metrics Export

## Phases
1. Database schema updates (if needed)
2. Backend API implementation
3. Frontend UI components
4. Testing (unit + E2E)
5. Documentation and deployment

## Current Phase: Not started

## Dependencies
- Existing metrics tracking system
- User authentication
- File download utilities
```

**Create implementation docs:**
```
implementation-docs/
├── phase-1-database.md
├── phase-2-backend.md
├── phase-3-frontend.md
├── phase-4-testing.md
└── phase-5-deployment.md
```

### Step 2: Execute Phase 1 (Fresh Thread)

**Clear context, start fresh thread:**
```
"Here's what we're building: [brief summary]

Current state: Planning complete, starting Phase 1

Task: Implement database schema changes for metrics export

Please read: implementation-docs/phase-1-database.md

Additional context:
- Current schema: [schema file path]
- Migration tool: Prisma
- No breaking changes allowed (live production DB)

Please implement Phase 1 and update plan.md when complete."
```

**Claude:**
- Reads only relevant context
- Implements Phase 1
- Updates plan.md
- Marks Phase 1 complete

### Step 3: Checkpoint and Clear

**After Phase 1:**
```
User: [Reviews changes, validates]

User: "Phase 1 looks good. Committing."

User: [Commits changes]

User: [Clears context or starts new thread]
```

**Safe checkpoint created:**
- Working code committed
- Can revert if Phase 2 fails
- Clean slate for next phase

### Step 4: Execute Phase 2 (Fresh Thread)

**Start fresh with minimal context:**
```
"Continuing metrics export feature.

Current state: Phase 1 complete (database ready), starting Phase 2

Task: Implement backend API endpoints for metrics export

Please read:
- implementation-docs/phase-2-backend.md
- plan.md (for context)

Note: Database schema already supports metrics storage (Phase 1 complete).

Please implement Phase 2 and update plan.md when complete."
```

**Repeat for each phase:**
- Fresh thread = fresh focus
- Minimal context = fast and efficient
- Update plan.md for continuity

---

## Advanced Patterns

### Pattern 1: Self-Contained Prompts (Maximum Efficiency)

**From Minute-Cat-823's variant:**
```
Phase 1: Plan with Claude, break into phases

Phase 2: Tell Claude each phase will be implemented by
         FRESH CHAT with ZERO CONTEXT

Phase 3: Have Claude create self-contained prompts for each phase

Phase 4: /clear and paste prompt 1 → implement → validate → /clear

Phase 5: Paste prompt 2 → implement → validate → /clear

Repeat until done.
```

**Example self-contained prompt:**
```markdown
# Phase 2: Backend API Implementation (ZERO CONTEXT VERSION)

## What You Need to Know
- We're building a metrics export feature
- Phase 1 (database) is COMPLETE
- Database has `metrics` table with: userId, metricName, value, timestamp
- User authentication uses JWT tokens

## Your Task
Create API endpoint: GET /api/metrics/export

## Requirements
1. Accept query params: format (csv|json), days (7|30|90)
2. Authenticate user via JWT
3. Fetch user's metrics from last N days
4. Return formatted file (CSV or JSON)
5. Enforce 100MB size limit

## Files to Create/Modify
- src/routes/metrics.routes.ts (new endpoint)
- src/controllers/metrics.controller.ts (new method)
- src/services/metrics-export.service.ts (new service)

## Success Criteria
- Endpoint returns 200 with file data
- CSV format: "date,metric,value" headers
- JSON format: {metrics: [{date, metric, value}]}
- 401 if not authenticated
- 413 if over 100MB

## When Done
Update plan.md: Mark Phase 2 complete
```

### Pattern 2: Scripted Workflow (yopla's Approach)

**Directory structure:**
```
documentation/<module>/feature/<feature_name>/
├── architecture.md    # System architecture
├── context.md         # High-level objectives
├── requirements.md    # User stories, validation
├── research.md        # Codebase analysis
├── design.md          # Implementation study
└── task.md            # Task list with file:line refs
```

**Slash commands:**
```
/architecture          → Review/update architecture
/feature metrics-export "Allow users to export metrics"
/research             → Analyze codebase
/requirements         → Review requirements
/design               → Review design
/tasks                → Review task list
/run_parallel         → Execute tasks
```

**Workflow:**
```bash
# 1. Create feature structure
/feature metrics-export "Export user metrics to CSV/JSON"

# 2. Research phase
/research
# Claude analyzes codebase, updates research.md

# 3. Requirements phase
/requirements
# Claude reviews, creates user stories

# 4. Design phase
/design
# Claude creates implementation plan

# 5. Execute
/tasks
# Claude shows task list

/run_parallel
# Claude executes all tasks

# 6. Next phase - repeat with fresh context
```

### Pattern 3: Agent Delegation for Repetitive Tasks

**Keep main context clean:**
```
Main Thread (Feature Implementation):
  → Implements business logic
  → Updates plan.md

Separate Agent/Thread (Testing):
  → Runs test suite
  → Fixes test failures
  → Reports results

Separate Agent/Thread (Linting):
  → Runs linters
  → Fixes style issues
  → Reports results

Result: Main thread stays focused on feature work
```

**From smurfman111:**
> "Success is all about context window management!"

---

## Context Management Best Practices

### DO:
✅ Create fresh threads for each phase
✅ Use documentation as compact reference
✅ Clear context regularly
✅ Separate plan.md from implementation docs
✅ Ask clarifying questions upfront
✅ Update plan.md after each phase
✅ Create safe checkpoints (commits)
✅ Use agents for repetitive tasks

### DON'T:
❌ Keep all conversation history "just in case"
❌ Mix concerns in single thread
❌ Share too much information at once
❌ Skip the clarifying questions
❌ Forget to update plan.md
❌ Continue when context feels bloated
❌ Pollute main thread with test cycles

---

## Token Usage Comparison

### Single Thread (Traditional):
```
Planning:          5,000 tokens
Phase 1:          +8,000 tokens (includes planning history)
Phase 2:         +12,000 tokens (includes planning + phase 1)
Phase 3:         +18,000 tokens (includes all previous)
Testing:         +25,000 tokens (includes everything)
────────────────────────────────
TOTAL:           68,000 tokens
```

### Fresh Threads Per Phase (This Workflow):
```
Planning:          5,000 tokens
Phase 1 (fresh):   3,000 tokens (just relevant docs)
Phase 2 (fresh):   3,500 tokens (just relevant docs)
Phase 3 (fresh):   4,000 tokens (just relevant docs)
Testing (agent):   5,000 tokens (separate thread)
────────────────────────────────
TOTAL:           20,500 tokens (70% reduction!)
```

---

## Real-World Results

### Production Metrics
- **Developer:** 15 years experience
- **Products:** Enterprise B2B with 2M users
- **Complexity:** Multiple microservices with interdependencies
- **Duration:** "Excellent results for several months"
- **Use cases:** Both simple and complex features
- **Token savings:** 50-70% reduction per feature

### Success Stories

**Quote from ByteSizedInnovator:**
> "Your prompt should clearly include the current state of the project, what needs to be done and any information that might help... Don't share too much information, thinking it might help Claude get better results, rather it will add to more confusion."

> "As the conversation continues and context gets filled up, Claude gets to lose critical information about the task to be implemented."

> "Ask if Claude has any clarifying questions. Almost all the time, it will come up with clarifying questions, which will be critical for the implementation plan."

---

## Troubleshooting

### Issue: Context still growing too large

**Solution:** Smaller phases
```
❌ Phase 1: Implement entire backend
✅ Phase 1a: Database schema
✅ Phase 1b: Repository layer
✅ Phase 1c: Service layer
✅ Phase 1d: API endpoints
```

### Issue: Lost context between phases

**Solution:** Better documentation
```markdown
# phase-2-context.md

## What Was Done in Phase 1
- Added `metrics` table with fields: userId, metricName, value, timestamp
- Created migration: 20231105_add_metrics_table.sql
- Tested migration on dev database

## Files Modified in Phase 1
- prisma/schema.prisma (lines 45-52)
- prisma/migrations/20231105_add_metrics_table.sql (new file)

## What Phase 2 Needs to Know
- Metrics table is ready
- Use Prisma client to query
- No breaking changes needed
```

### Issue: Unclear phase boundaries

**Solution:** Define clear deliverables
```markdown
## Phase 1: Database
**Deliverable:** Metrics table exists and can be queried
**Validation:** Run `npm run db:test` - should pass

## Phase 2: Backend API
**Deliverable:** API endpoint returns metrics data
**Validation:** `curl /api/metrics/export` - returns 200

## Phase 3: Frontend
**Deliverable:** UI shows export button and downloads file
**Validation:** Click button - file downloads
```

---

## Integration with Other Workflows

### Combine with TDD Workflow

**Best of both worlds:**
```
Documentation-Driven for structure:
  ✓ Fresh threads per phase
  ✓ plan.md for tracking
  ✓ Context management

TDD for implementation:
  ✓ Tests define requirements
  ✓ Autonomous execution
  ✓ Binary pass/fail validation

Combined workflow:
1. Plan phases (Documentation-Driven)
2. For each phase (fresh thread):
   a. Write tests first (TDD)
   b. Go AFK (TDD)
   c. Claude implements until tests pass (TDD)
   d. Update plan.md (Documentation-Driven)
   e. Clear context (Documentation-Driven)
3. Next phase
```

---

## Template: plan.md

```markdown
# Feature: [Feature Name]

## Overall Goal
[Brief description of what we're building and why]

## Phases
- [ ] Phase 1: [Phase name and brief description]
- [ ] Phase 2: [Phase name and brief description]
- [ ] Phase 3: [Phase name and brief description]
- [ ] Phase 4: [Phase name and brief description]

## Current Status
[Which phase we're on, what's been completed, what's next]

## Key Decisions
- [Important architectural or implementation decisions]
- [Rationale for choices made]

## Dependencies
- [External dependencies this feature relies on]
- [Other features or services that must exist first]

## Risks & Mitigations
- [Potential issues and how we'll handle them]

## Notes
- [Useful context, commit hashes, doc links, etc.]

## Completion Criteria
- [ ] All phases complete
- [ ] Tests passing
- [ ] Documentation updated
- [ ] Deployed to production
```

---

## Template: Phase Implementation Doc

```markdown
# Phase [N]: [Phase Name]

## Context
[Brief reminder of overall feature and what previous phases accomplished]

## Current State
[What exists now, what files are relevant, what's been done]

## Task
[Specific task for this phase - what needs to be built/changed]

## Files to Create/Modify
- [path/to/file1.ts] - [what to do]
- [path/to/file2.ts] - [what to do]

## Technical Details
[API contracts, schemas, interfaces, patterns to follow]

## Dependencies
[Libraries, services, APIs this phase uses]

## Success Criteria
- [ ] [Specific deliverable 1]
- [ ] [Specific deliverable 2]
- [ ] [Validation method]

## Notes
[Anything else Claude should know]

## When Complete
Update plan.md: Mark Phase [N] complete, note any important details
```

---

## Related Skills

- **tdd-workflow**: For test-driven implementation within phases
- **backend-dev-guidelines**: For backend architecture patterns
- **frontend-dev-guidelines**: For frontend implementation patterns

---

## Further Reading

- [Reddit: "Claude Code workflow that's been working well for me"](https://www.reddit.com/r/ClaudeAI/comments/1gqm0q1/)
- Minute-Cat-823's self-contained prompts variant
- smurfman111's context window management tips
- yopla's scripted workflow approach

---

**Token Preservation: ⭐⭐⭐⭐⭐ (BEST)**
**Task Adherence: ⭐⭐⭐⭐⭐**
**Production Proven: ✅ 2M users, enterprise B2B, 15 years experience**

---
description: Execute a feature phase with fresh context (maximum token efficiency)
argument-hint: "<feature-name> <phase-number>"
---

You are a phase execution specialist using the Documentation-Driven Phase Workflow for maximum token efficiency.

Execute Phase $ARGUMENTS with FRESH CONTEXT and MINIMAL TOKEN USAGE.

## Instructions

1. **Parse arguments**:
   - feature-name: First argument (e.g., "metrics-export")
   - phase-number: Second argument (e.g., "1", "2", "3")

2. **Load ONLY essential context**:
   - Read: documentation/features/<feature-name>/plan.md
   - Read: documentation/features/<feature-name>/design.md (only the section for this phase)
   - Read: documentation/features/<feature-name>/tasks.md (only tasks for this phase)

   **DO NOT read:**
   - ❌ Full conversation history (not in context)
   - ❌ All previous phases (only what's needed)
   - ❌ Entire design.md (only current phase section)

3. **Understand current state**:
   - From plan.md: What phases are already complete?
   - From plan.md: What's the overall goal?
   - What files were modified in previous phases? (if relevant)

4. **Execute this phase**:

   ### Phase Execution Checklist
   - [ ] Read phase-specific tasks from tasks.md
   - [ ] Review success criteria for this phase from design.md
   - [ ] Implement changes for this phase ONLY
   - [ ] Test changes (unit tests, integration tests as needed)
   - [ ] Validate against success criteria
   - [ ] Update plan.md: Mark phase complete, add notes

5. **Implementation approach**:
   - Focus ONLY on this phase's scope
   - Do NOT add features from future phases
   - Do NOT refactor code from previous phases (unless blocking)
   - Follow existing patterns from research.md
   - Use TDD if tests are defined

6. **After implementation**:
   - Run tests to verify
   - Update plan.md with:
     ```markdown
     ## Progress Log

     ### [DATE] - Phase [N] Complete
     - [What was implemented]
     - [Files modified]
     - [Any important decisions]
     - [Any blockers or notes for next phase]

     ## Current Status
     Status: Phase [N] complete
     Current Phase: Ready for Phase [N+1]
     ```

7. **Provide summary**:
   ```
   Phase [N] Execution Complete: [phase-name]

   Implemented:
   ✓ [Task 1]
   ✓ [Task 2]
   ✓ [Task 3]

   Files Modified:
   - src/file1.ts (lines 10-50)
   - src/file2.ts (new file)

   Tests:
   ✓ All [X] tests passing

   Next Steps:
   → Clear context (Esc key)
   → Review changes
   → Commit changes
   → Run: /phase-exec [feature-name] [N+1]

   Updated: documentation/features/[feature-name]/plan.md
   ```

## Token Efficiency Principles

### DO (Token Efficient):
✅ Load ONLY current phase context
✅ Reference documentation files (compact)
✅ Clear, specific implementation
✅ Update plan.md for continuity

### DON'T (Token Wasteful):
❌ Include entire conversation history
❌ Load all phase documentation at once
❌ Explain what was done in previous phases (unless needed)
❌ Keep accumulated context "just in case"

## Phase Execution Pattern

```
Traditional Approach (Token Wasteful):
┌─────────────────────────────────┐
│ All planning discussion: 5k tokens
│ Phase 1 work: 3k tokens
│ Phase 2 work: 4k tokens          } 20k tokens
│ Phase 3 work: 5k tokens
│ All accumulated context: 3k tokens
└─────────────────────────────────┘

This Command (Token Efficient):
┌─────────────────────────────────┐
│ Phase 1: plan.md + design.md(P1) only
│ → 2k tokens → Implement → Update plan.md
│ → Clear context
│
│ Phase 2: plan.md + design.md(P2) only
│ → 2k tokens → Implement → Update plan.md  } 7k tokens (65% reduction!)
│ → Clear context
│
│ Phase 3: plan.md + design.md(P3) only
│ → 3k tokens → Implement → Update plan.md
│ → Clear context
└─────────────────────────────────┘
```

## Example Usage

### Phase 1: Database Schema
```
/phase-exec metrics-export 1
```

Claude loads:
- documentation/features/metrics-export/plan.md
- documentation/features/metrics-export/design.md (Phase 1 section only)
- documentation/features/metrics-export/tasks.md (Phase 1 tasks only)

Claude implements:
- Database schema changes
- Migrations
- Repository layer (if in Phase 1)

Claude updates:
- plan.md with Phase 1 completion

User:
- Reviews changes
- Commits
- Clears context (Esc)
- Runs: /phase-exec metrics-export 2

### Phase 2: API Implementation
```
/phase-exec metrics-export 2
```

Claude loads:
- documentation/features/metrics-export/plan.md (knows Phase 1 is done)
- documentation/features/metrics-export/design.md (Phase 2 section only)
- documentation/features/metrics-export/tasks.md (Phase 2 tasks only)

Claude implements:
- API endpoints
- Controllers
- Services
- Validation

Claude updates:
- plan.md with Phase 2 completion

## Self-Contained Prompts (Advanced)

For maximum efficiency, combine with self-contained prompt pattern:

1. Run: `/phase-exec metrics-export 1`
2. After completion, ask: "Create self-contained prompt for Phase 2"
3. Claude generates:
   ```markdown
   # Phase 2: API Implementation (ZERO CONTEXT)

   ## What You Need to Know
   - Feature: metrics-export (export user metrics to CSV/JSON)
   - Phase 1 COMPLETE: Database schema ready, MetricsRepository exists
   - Database table: metrics (userId, metricName, value, timestamp)

   ## Your Task
   Implement API endpoints: GET /api/metrics/export

   ## Requirements
   [Detailed requirements with no assumptions]

   ## Files to Create/Modify
   [Specific files with what to do]

   ## Success Criteria
   [Clear pass/fail criteria]
   ```

4. User clears context
5. User pastes self-contained prompt
6. Claude implements with ZERO previous context

## Integration with Workflows

### With TDD Workflow:
```
/phase-exec metrics-export 2

Phase starts with:
- Tests already written (from Phase 1 or separate test phase)
- Claude implements until tests pass
- Self-correcting: failed tests guide fixes
```

### With Documentation-Driven Workflow:
```
This command IS the implementation of Documentation-Driven Workflow!

1. Planning creates: plan.md, design.md, tasks.md
2. /phase-exec runs each phase with fresh context
3. Token savings: 50-70% reduction
```

## Quality Standards
- Each phase is independently complete
- Tests pass before marking phase complete
- plan.md always reflects true status
- No phase depends on context from previous thread
- Documentation serves as source of truth

## Troubleshooting

### Issue: Phase needs context from previous phase
**Solution:** Add to design.md Phase N section:
```markdown
### Phase 2: API Implementation

**Context from Phase 1:**
- MetricsRepository class created at: src/repositories/metrics.repository.ts
- Database schema: metrics table with userId, metricName, value, timestamp
- Use: `metricsRepo.findByUserId(userId, days)` to fetch data

**This Phase Task:**
[Rest of phase details]
```

### Issue: Don't know what phase we're on
**Solution:** Check plan.md Current Status section - it's the source of truth

### Issue: Need to modify previous phase's code
**Solution:**
- Load minimal context: just that file
- Make specific change
- Update plan.md with note
- Continue current phase

## Related Commands
- `/feature <name> <description>` - Create feature structure first
- `/research <feature-name>` - Research phase before execution
- `/clarify <feature-name>` - Ask clarifying questions before phases

---

**Token Preservation: ⭐⭐⭐⭐⭐ (MAXIMUM)**
**Based on: ByteSizedInnovator's workflow (5/5 rating, 50-70% token reduction)**

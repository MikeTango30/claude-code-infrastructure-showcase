# Workflow Best Practices

Based on comprehensive analysis of Reddit Claude Code workflows from 9+ developers with proven production results.

## Overview

This document distills the best practices from three major Reddit workflows:
1. **Documentation-Driven Phase Workflow** (ByteSizedInnovator) - ⭐⭐⭐⭐⭐ Token Efficiency
2. **Test-Driven Development Workflow** (neo17th) - ⭐⭐⭐⭐⭐ Task Adherence
3. **Constraint-Heavy Template** (Suspicious-Prune-442) - ⭐⭐☆☆☆ (what NOT to do)

## Quick Reference

### Choose Your Workflow

| Workflow | Best For | Token Efficiency | Task Adherence |
|----------|----------|------------------|----------------|
| **Documentation-Driven** | Complex features, multiple phases, token budget concerns | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |
| **TDD** | Clear requirements, autonomous execution, production-ready code | ⭐⭐⭐⭐☆ | ⭐⭐⭐⭐⭐ |
| **Combined** | Enterprise features with both needs | ⭐⭐⭐⭐⭐ | ⭐⭐⭐⭐⭐ |

### Quick Start Commands

```bash
# Create feature structure
/feature metrics-export "Export user metrics to CSV and JSON"

# Ask clarifying questions (prevents costly mistakes)
/clarify metrics-export

# Research existing patterns
/research metrics-export

# Execute phase with fresh context
/phase-exec metrics-export 1
```

---

## The Two Winning Approaches

### 1. Documentation-Driven Phase Workflow (Token Champion)

**Author:** ByteSizedInnovator (15 years experience, 2M users)
**Rating:** ⭐⭐⭐⭐⭐ (5/5) for token efficiency
**Savings:** 50-70% token reduction

#### Core Principles

1. **Fresh Threads Per Phase**
   - Start each phase with clean context
   - No accumulated conversation history
   - Maximum token efficiency

2. **Two-Document System**
   - `plan.md` - High-level phases and progress tracking
   - `implementation-docs/` - Detailed phase instructions

3. **Clarifying Questions First**
   - Always ask before implementing
   - Catches misunderstandings early
   - Saves rework time

4. **Regular Context Clearing**
   - Clear after each phase
   - Prevents token accumulation
   - Fresh focus for next phase

#### Implementation

```bash
# 1. Planning Phase (Main Thread)
User: "I need metrics export to CSV/JSON"
Claude: "I have clarifying questions: [10 questions]"
User: [Answers questions]
Claude: [Creates plan.md and phase docs]

# 2. Phase 1 (Fresh Thread)
User: "/phase-exec metrics-export 1"
Claude: [Loads only Phase 1 context, implements, updates plan.md]
User: [Reviews, commits, clears context]

# 3. Phase 2 (Fresh Thread)
User: "/phase-exec metrics-export 2"
Claude: [Loads only Phase 2 context, implements, updates plan.md]
User: [Reviews, commits, clears context]

# Repeat for all phases
```

#### Token Savings

```
Traditional Single Thread:
Planning: 5k tokens
+ Phase 1: 8k tokens (includes planning)
+ Phase 2: 12k tokens (includes planning + phase 1)
+ Phase 3: 18k tokens (includes all previous)
= 43k tokens total

Documentation-Driven:
Planning: 5k tokens (separate)
Phase 1: 2k tokens (fresh)
Phase 2: 2.5k tokens (fresh)
Phase 3: 3k tokens (fresh)
= 12.5k tokens total (71% reduction!)
```

#### Tools

- **Skill:** `doc-driven-workflow`
- **Commands:** `/feature`, `/clarify`, `/research`, `/phase-exec`
- **Agent:** `phase-executor`

---

### 2. Test-Driven Development Workflow (Task Champion)

**Author:** neo17th (10+ microservices, 2M users)
**Rating:** ⭐⭐⭐⭐⭐ (5/5) for task adherence
**Results:** Ships production features in 2-3 days

#### Core Principles

1. **Tests First**
   - Write tests before implementation
   - Tests define exact requirements
   - Binary pass/fail = no ambiguity

2. **Autonomous Execution**
   - Tell Claude "I'm going AFK"
   - Claude works without supervision
   - Completes entire checklist

3. **Self-Correcting**
   - Failed tests guide fixes
   - No manual debugging loops
   - Continues until 100% passing

4. **Production Ready**
   - Full test coverage
   - Works with 15k line files
   - Proven with 2M users

#### Implementation

```bash
# 1. Brainstorm & Plan
User: "Build metrics export feature"
Claude: [Creates build plan, identifies interfaces]

# 2. Write Tests FIRST
Claude: [Writes comprehensive test suite]
- Happy path tests
- Edge case tests
- Error case tests
- Integration tests

# 3. Run Tests (RED phase)
npm test
# ❌ 15/15 tests failing (expected)

# 4. Go AFK - Autonomous Implementation
User: "I'm going AFK. Implement until all tests pass."

Claude: [Autonomous loop]
- Implement feature
- Run tests: ❌ 10 failing
- Fix issues
- Run tests: ❌ 5 failing
- Fix more
- Run tests: ❌ 2 failing
- Final fixes
- Run tests: ✅ 15/15 passing

# 5. Validation
All tests pass = Feature complete = Ready for production
```

#### Test Structure Example

```typescript
describe('MetricsExportService', () => {
  // Happy path
  it('should export metrics to CSV format', async () => {
    const result = await service.exportToCSV(userId, { days: 30 });
    expect(result.format).toBe('text/csv');
    expect(result.data).toContain('date,metric,value');
  });

  // Edge case
  it('should handle empty dataset', async () => {
    const result = await service.exportToCSV(emptyUserId, { days: 30 });
    expect(result.data).toBe('date,metric,value\n'); // Just header
  });

  // Error case
  it('should require authentication', async () => {
    await expect(service.exportToCSV(null, { days: 30 }))
      .rejects.toThrow('Authentication required');
  });

  // Size limit
  it('should enforce 100MB limit', async () => {
    await expect(service.exportToCSV(hugeUserId, { days: 30 }))
      .rejects.toThrow('Export exceeds 100MB limit');
  });
});
```

#### Tools

- **Skill:** `tdd-workflow`
- **Agent:** `tdd-driver`

---

## The Combined Approach (Best of Both)

For enterprise features that need both token efficiency AND production quality:

### Workflow

```
1. Planning (Documentation-Driven)
   → /feature [name] [description]
   → /clarify [name]
   → /research [name]
   → Create plan.md with phases

2. For Each Phase (Fresh Thread):
   a. Write Tests First (TDD)
      → Define success criteria as tests
      → Comprehensive coverage

   b. Execute Phase (Documentation-Driven)
      → /phase-exec [name] [phase]
      → Loads minimal context

   c. Implement (TDD)
      → "I'm going AFK"
      → Autonomous until tests pass

   d. Validate & Checkpoint (Both)
      → All tests passing ✅
      → Update plan.md
      → Commit changes
      → Clear context

3. Next Phase (Fresh Thread)
   → Repeat 2a-2d
```

### Example: Metrics Export Feature

```bash
# Planning
/feature metrics-export "Export user metrics to CSV and JSON"
/clarify metrics-export  # Answers reveal need for 100MB limit
/research metrics-export # Finds CSV library already in use

# Phase 1: Database (Fresh Thread)
/phase-exec metrics-export 1
# Tests written first
# Claude implements until tests pass
# Commit, clear context

# Phase 2: API (Fresh Thread)
/phase-exec metrics-export 2
# Tests written first
# Claude implements until tests pass
# Commit, clear context

# Phase 3: Frontend (Fresh Thread)
/phase-exec metrics-export 3
# Tests written first (Cypress E2E)
# Claude implements until tests pass
# Commit, clear context

# Result: Production-ready in 2-3 days with 70% token savings
```

---

## What NOT To Do (Anti-Patterns)

### ❌ Constraint-Heavy Template Workflow

**Why it fails:**
- Verbose template repeated frequently (400+ tokens each time)
- Forces re-reading CLAUDE.md multiple times
- Reactive (fixes problems after they occur)
- Users report "having to yell at it"
- Rules often ignored anyway

**Quote from user:**
> "CLAUDE.md probably doesn't even get 1% of the computation you are paying for"

**Token waste:**
- Template repetition: +400 tokens per phase
- CLAUDE.md re-reading: +200-500 tokens per reminder
- Defensive prompting: ~30-40% of total tokens

**Instead:** Use proactive structure (Documentation-Driven or TDD)

---

## Best Practices Summary

### DO ✅

**For Token Efficiency:**
- ✅ Use fresh threads per phase
- ✅ Create documentation as reference
- ✅ Clear context regularly
- ✅ Load minimal relevant context
- ✅ Use agents for repetitive tasks

**For Task Adherence:**
- ✅ Write tests before implementation
- ✅ Ask clarifying questions upfront
- ✅ Use objective verification (tests)
- ✅ Create clear success criteria
- ✅ Enable autonomous execution

**For Both:**
- ✅ Break work into phases
- ✅ Create safe checkpoints
- ✅ Update progress tracking
- ✅ Follow existing patterns

### DON'T ❌

**Token Waste:**
- ❌ Keep all conversation history
- ❌ Repeat verbose templates
- ❌ Force re-reading same docs
- ❌ Mix concerns in single thread
- ❌ Accumulate context "just in case"

**Task Drift:**
- ❌ Skip clarifying questions
- ❌ Use subjective success criteria
- ❌ Allow scope creep
- ❌ Implement without tests
- ❌ Police with reactive constraints

**Architecture:**
- ❌ Fight Claude's tendencies
- ❌ Create defensive templates
- ❌ Assume rules are followed
- ❌ Skip planning phase

---

## Real-World Results

### Documentation-Driven Workflow
- **Developer:** 15 years experience
- **Products:** Enterprise B2B, 2M users
- **Duration:** Several months of excellent results
- **Complexity:** Multiple microservices with interdependencies
- **Token savings:** 50-70% reduction
- **Use cases:** Both simple and complex features

### TDD Workflow
- **Developer:** 10+ microservices
- **Users:** 2M in production
- **Delivery:** 2-3 days for fully tested features
- **File sizes:** Some 15k lines of code
- **Test frameworks:** Vitest (unit), Cypress (E2E)
- **Session:** ~5 hours on $100 plan
- **Quality:** "Phenomenal results" with "fully tested production features"

### Combined Approach
- Best of both worlds
- Maximum token efficiency + production quality
- Proven in enterprise environments
- Scales to complex multi-phase features

---

## Implementation Checklist

### Starting a New Feature

- [ ] Create feature structure: `/feature [name] [description]`
- [ ] Ask clarifying questions: `/clarify [name]`
- [ ] Research codebase: `/research [name]`
- [ ] Create plan.md with phases
- [ ] Write test scenarios (if using TDD)

### Executing Each Phase

- [ ] Start fresh thread (clear previous context)
- [ ] Load minimal context for this phase
- [ ] Write tests first (if using TDD)
- [ ] Implement until tests pass
- [ ] Validate against success criteria
- [ ] Update plan.md
- [ ] Commit changes
- [ ] Clear context

### Completing Feature

- [ ] All phases complete
- [ ] All tests passing (100%)
- [ ] Documentation updated
- [ ] Code reviewed
- [ ] Ready for production

---

## Troubleshooting

### Problem: Context growing too large
**Solution:** Smaller phases, fresh threads more frequently

### Problem: Lost context between phases
**Solution:** Better documentation in plan.md and phase docs

### Problem: Tests not guiding implementation
**Solution:** Make tests more specific and actionable

### Problem: Can't work autonomously
**Solution:** Clear "I'm going AFK" instruction with checklist

### Problem: Scope creep
**Solution:** Strict phase boundaries, task lists

### Problem: Token budget exceeded
**Solution:** Use Documentation-Driven workflow

### Problem: Quality concerns
**Solution:** Use TDD workflow

### Problem: Both token and quality concerns
**Solution:** Use Combined approach

---

## Tools Reference

### Skills
- `doc-driven-workflow` - Phase-based with fresh contexts
- `tdd-workflow` - Test-first autonomous implementation

### Commands
- `/feature` - Create feature structure
- `/clarify` - Ask clarifying questions
- `/research` - Analyze codebase
- `/phase-exec` - Execute phase with fresh context

### Agents
- `phase-executor` - Execute phases with minimal context
- `tdd-driver` - Autonomous TDD implementation

---

## Further Reading

- [Reddit Workflows Analysis](./reddit-workflows-analysis.md) - Full analysis of 9 workflows
- [Documentation-Driven Workflow Skill](..skills/doc-driven-workflow/SKILL.md)
- [TDD Workflow Skill](../skills/tdd-workflow/SKILL.md)

---

## Credits

**Workflows analyzed from:**
- ByteSizedInnovator (Documentation-Driven Phase Workflow)
- neo17th (Test-Driven Development Workflow)
- Suspicious-Prune-442 (Constraint-Heavy Template - anti-pattern)
- Additional insights from: mfreeze77, blakeyuk, Minute-Cat-823, yopla, smurfman111, konmik-android

**Source:** Reddit r/ClaudeAI community discussions (200+ upvotes combined)

---

**Last Updated:** 2025-11-05
**Status:** Production-ready, proven with 2M+ users
**Recommended:** Combined approach for enterprise features

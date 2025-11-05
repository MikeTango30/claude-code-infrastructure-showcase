---
name: tdd-workflow
description: Test-Driven Development workflow for autonomous feature implementation. Use when implementing features with testable requirements, shipping production-ready code, or needing autonomous execution with objective pass/fail criteria. Based on proven workflow shipping features to 2M users in 2-3 days.
---

# Test-Driven Development (TDD) Workflow

## Purpose

Enable autonomous, high-quality feature development through test-first implementation. This workflow allows Claude to work independently with clear success criteria, shipping fully tested production features in days instead of weeks.

**Based on:** neo17th's workflow (205 upvotes, proven with 2M users, 10+ microservices)

## When to Use This Skill

Automatically activates when:
- Implementing new features with clear requirements
- Need autonomous execution without constant supervision
- Want objective verification (tests pass/fail)
- Working with complex codebases (10k+ lines per file)
- Shipping production-ready code
- Need self-correcting implementation (failed tests guide fixes)

---

## Token Preservation: ⭐⭐⭐⭐☆ (4/5)

**Why it's efficient:**
- Tests provide immediate, automated validation (no manual Q&A loops)
- Reduces debugging loops by catching issues via test failures
- Clear success criteria minimize ambiguous conversations
- Can run autonomously (fewer human interventions = fewer context resets)
- Task lists keep focus narrow and context clean

**Token savings:**
- Test-driven: ~40-60% reduction in debugging conversations
- Autonomous execution: ~30-50% reduction in human interventions
- Clear pass/fail: Eliminates ambiguous "does this look right?" discussions

## Task Adherence: ⭐⭐⭐⭐⭐ (5/5)

**Why it works:**
- **Objective verification:** Tests provide binary pass/fail (no subjectivity)
- **Proven results:** Ships production features to 2M users in 2-3 days
- **Autonomous completion:** Can finish complex features without supervision
- **Self-correcting:** Failed tests automatically guide fixes
- **Real production use:** Not theoretical - proven in enterprise environment

---

## Quick Start

### TDD Feature Implementation Checklist

1. **Brainstorm Phase**
   - [ ] Discuss feature requirements with user
   - [ ] Clarify success criteria
   - [ ] Identify affected interfaces/APIs/schemas

2. **Planning Phase**
   - [ ] Create build plan "for junior dev who doesn't know this code"
   - [ ] Have Claude read relevant interfaces, API contracts, DB schemas
   - [ ] Define test scenarios covering all requirements
   - [ ] Create implementation checklist

3. **Test-First Phase**
   - [ ] Write test cases FIRST (before implementation)
   - [ ] Create boilerplate function signatures
   - [ ] Ensure tests fail initially (red phase)
   - [ ] Review test coverage with user

4. **Implementation Phase**
   - [ ] Tell Claude: "I am going AFK, finish the checklist"
   - [ ] Let Claude work autonomously
   - [ ] Claude implements until ALL tests pass (green phase)
   - [ ] Claude refactors while maintaining passing tests

5. **Validation Phase**
   - [ ] Run full test suite
   - [ ] 100% tests passing required
   - [ ] Review implementation
   - [ ] Ship to production

---

## Core Principles

### 1. Tests Define Requirements

**Good test structure:**
```typescript
describe('Feature: User Authentication', () => {
  it('should return JWT token on successful login', async () => {
    // Arrange: Set up test data
    const credentials = { email: 'test@example.com', password: 'correct' };

    // Act: Execute the feature
    const result = await authService.login(credentials);

    // Assert: Verify expected behavior
    expect(result.token).toBeDefined();
    expect(result.token).toMatch(/^eyJ/); // JWT format
    expect(result.expiresIn).toBe(3600);
  });

  it('should throw error on invalid credentials', async () => {
    const credentials = { email: 'test@example.com', password: 'wrong' };

    await expect(authService.login(credentials))
      .rejects
      .toThrow('Invalid credentials');
  });
});
```

**Why this works:**
- Tests document exact expected behavior
- Binary pass/fail eliminates ambiguity
- Failed tests guide exactly what needs fixing

### 2. Autonomous Execution

**Enable autonomous mode:**
```
"I am going AFK. Please complete the checklist:
1. Implement user authentication service
2. Ensure all 15 tests pass
3. Refactor for performance
4. Update API documentation

I'll check back in 2 hours. Leave a summary when done."
```

**Claude will:**
- Work through checklist systematically
- Run tests after each change
- Fix failures automatically
- Continue until 100% passing
- Provide completion summary

### 3. Self-Correcting Loop

**Automatic fix cycle:**
```
Test fails → Claude analyzes error → Claude fixes code → Test passes
```

**Example:**
```
❌ Test: "should validate email format" - FAILED
   Expected: ValidationError
   Received: User created successfully

🔧 Claude analysis: Missing email validation in UserService
🔧 Claude adds: Zod schema with email validation
🔧 Claude re-runs test

✅ Test: "should validate email format" - PASSED
```

---

## Implementation Guide

### Step 1: Brainstorm and Plan

**User provides:**
```
"I need a feature that allows users to export their usage metrics to CSV and JSON formats.
Requirements:
- Support CSV and JSON exports
- Include last 30 days of data
- Authenticate users
- Limit to 100MB file size"
```

**Claude creates:**
1. Build plan document
2. API contract definition
3. Test scenario list
4. Implementation checklist

### Step 2: Write Tests First

**Example test suite:**
```typescript
// tests/metrics-export.test.ts
describe('Metrics Export Feature', () => {
  describe('CSV Export', () => {
    it('should export metrics to CSV format', async () => {
      const result = await metricsService.exportToCSV(userId, { days: 30 });
      expect(result.format).toBe('text/csv');
      expect(result.data).toContain('date,metric,value');
    });

    it('should limit to 30 days of data', async () => {
      const result = await metricsService.exportToCSV(userId, { days: 30 });
      const lines = result.data.split('\n');
      expect(lines.length).toBeLessThanOrEqual(31); // header + 30 days
    });

    it('should enforce 100MB size limit', async () => {
      await expect(metricsService.exportToCSV(userWithLotsOfData))
        .rejects.toThrow('Export size exceeds 100MB limit');
    });
  });

  describe('JSON Export', () => {
    it('should export metrics to JSON format', async () => {
      const result = await metricsService.exportToJSON(userId, { days: 30 });
      expect(result.format).toBe('application/json');
      expect(JSON.parse(result.data)).toHaveProperty('metrics');
    });
  });

  describe('Authentication', () => {
    it('should require authentication', async () => {
      await expect(metricsService.exportToCSV(null))
        .rejects.toThrow('Authentication required');
    });
  });
});
```

### Step 3: Create Boilerplate

**Stub implementations:**
```typescript
// src/services/metrics-export.service.ts
export class MetricsExportService {
  async exportToCSV(userId: string, options: ExportOptions): Promise<ExportResult> {
    // TODO: Implement
    throw new Error('Not implemented');
  }

  async exportToJSON(userId: string, options: ExportOptions): Promise<ExportResult> {
    // TODO: Implement
    throw new Error('Not implemented');
  }
}
```

### Step 4: Go AFK - Let Claude Implement

**Prompt:**
```
I am going AFK. Please implement the metrics export feature to make all tests pass.

Checklist:
1. Implement exportToCSV method
2. Implement exportToJSON method
3. Add authentication checks
4. Add size limit validation
5. Ensure all 8 tests pass
6. Refactor for performance
7. Add error handling

Run tests after each change. Fix any failures. Provide summary when 100% passing.
```

**Claude will:**
- Implement each method
- Run tests continuously
- Fix failures automatically
- Refactor while maintaining passing tests
- Provide completion report

### Step 5: Validate and Ship

**Review Claude's summary:**
```
✅ All 8 tests passing
✅ CSV export implemented with proper formatting
✅ JSON export implemented with structured data
✅ Authentication checks added
✅ 100MB size limit enforced
✅ Error handling for edge cases
✅ Performance optimized (streaming for large datasets)

Ready for production deployment.
```

---

## Advanced Patterns

### Multi-Service Testing

**For 10+ microservices:**
```typescript
// Integration test across services
describe('Cross-Service: Metrics Export', () => {
  it('should fetch data from analytics-service and export', async () => {
    // Mock analytics-service response
    mockAnalyticsService.getUserMetrics.mockResolvedValue(mockData);

    const result = await metricsService.exportToCSV(userId);

    expect(mockAnalyticsService.getUserMetrics).toHaveBeenCalledWith(userId);
    expect(result.data).toContain(mockData[0].value);
  });
});
```

### Large File Testing (15k+ lines)

**Claude can handle:**
- Files with 15,000+ lines of code
- Extracts exact excerpts needed
- Maintains context across large codebases

**Example:**
```typescript
// Even in huge files, Claude finds the right function
// File: src/services/mega-service.ts (15,000 lines)

// Claude locates line 8,432 for testing:
it('should use correct pricing calculation', () => {
  const price = megaService.calculateComplexPricing(params);
  expect(price).toBe(expectedValue);
});
```

### E2E Testing with Cypress

**Full workflow tests:**
```typescript
// cypress/e2e/metrics-export.cy.ts
describe('Metrics Export E2E', () => {
  it('should export CSV from UI', () => {
    cy.login('user@example.com');
    cy.visit('/metrics');
    cy.get('[data-testid="export-csv"]').click();
    cy.get('[data-testid="download-link"]').should('be.visible');
    cy.readFile('downloads/metrics.csv').should('contain', 'date,metric,value');
  });
});
```

---

## Real-World Results

### Production Metrics
- **Codebase:** 10+ microservices
- **File sizes:** Some 15k lines of code
- **Test frameworks:** Vitest (unit), Cypress (E2E)
- **Development time:** 2-3 days for fully tested features
- **Users:** 2M+ production users
- **Session duration:** ~5 hours on $100 plan
- **Quality:** "Phenomenal results" with "fully tested production features"

### Success Stories

**Quote from neo17th:**
> "I tell the agent that I am AFK, and it needs to finish up the list - which it actually ends up finishing."

> "Imagine, shipping fully tested production features being shipped in less than 2-3 days."

> "Beauty is that even with super long files, Claude Code is able to find and pull the exact excerpts that it needs to solve the problem."

---

## Common Patterns

### Pattern 1: Multiple Test Types

**Combine unit + integration + E2E:**
```typescript
// Unit test
it('should format CSV correctly', () => {
  expect(formatCSV(data)).toBe('a,b,c\n1,2,3');
});

// Integration test
it('should fetch and format data', async () => {
  const result = await service.exportData(userId);
  expect(result).toMatchSchema(exportSchema);
});

// E2E test (Cypress)
it('should download export file', () => {
  cy.clickExport();
  cy.verifyDownload('metrics.csv');
});
```

### Pattern 2: Test-Driven Refactoring

**Safe refactoring with test safety net:**
```
1. All tests passing (green)
2. Refactor code
3. Tests still passing? → Good refactor
4. Tests failing? → Revert or fix
```

### Pattern 3: Progressive Test Addition

**Add tests as you discover edge cases:**
```typescript
// Initial test
it('should export data', () => { ... });

// Discovered edge case → Add test
it('should handle empty data', () => { ... });

// Another edge case → Add test
it('should handle special characters in CSV', () => { ... });
```

---

## Troubleshooting

### Issue: Tests not guiding implementation

**Solution:** Make tests more specific
```typescript
// ❌ Too vague
it('should work', () => {
  expect(result).toBeTruthy();
});

// ✅ Specific and actionable
it('should return array of User objects with id, name, email fields', () => {
  expect(result).toEqual([
    { id: 1, name: 'Alice', email: 'alice@example.com' },
    { id: 2, name: 'Bob', email: 'bob@example.com' }
  ]);
});
```

### Issue: Claude not autonomous

**Solution:** Clear AFK instruction
```
❌ "Can you implement this?"
✅ "I am going AFK. Complete the checklist. Fix all test failures. Provide summary when done."
```

### Issue: Tests passing but feature broken

**Solution:** Add integration/E2E tests
```typescript
// Don't just test units, test the full flow
it('should complete entire export workflow', async () => {
  const result = await fullWorkflow(userId);
  expect(result.success).toBe(true);
  expect(result.downloadUrl).toBeDefined();
});
```

---

## Integration with Other Workflows

### Combine with Documentation-Driven Workflow

**Best of both worlds:**
1. Use Documentation-Driven for planning and context management
2. Use TDD for implementation and verification
3. Fresh threads per phase (Documentation-Driven)
4. Tests for validation (TDD)

**Workflow:**
```
Phase 1: Plan (Documentation-Driven)
  → Create plan.md
  → Create test scenarios
  → Get clarifications

Phase 2: Implement (TDD)
  → Fresh thread
  → Write tests first
  → Go AFK
  → Claude implements autonomously

Phase 3: Validate (Both)
  → Tests pass (TDD)
  → Update plan.md (Documentation-Driven)
  → Clear context, move to next phase
```

### Multi-Agent Coordination

**From mfreeze77's approach:**
- Split work between "4 Jr devs" (separate threads)
- Use Cline for validation between tasks
- Create troubleshooting guides for each phase
- Each "dev" has specific tests to pass

---

## Best Practices

### DO:
✅ Write tests BEFORE implementation
✅ Make tests specific and actionable
✅ Use autonomous mode ("I am AFK")
✅ Let failed tests guide fixes
✅ Combine unit + integration + E2E tests
✅ Create detailed checklists
✅ Review test coverage before starting

### DON'T:
❌ Write vague tests
❌ Skip test-first approach
❌ Micromanage during autonomous execution
❌ Accept passing tests without reviewing implementation
❌ Skip edge case tests
❌ Forget to update tests when requirements change

---

## Related Skills

- **backend-dev-guidelines**: For backend test structure and patterns
- **frontend-dev-guidelines**: For React component testing
- **error-tracking**: For Sentry integration in tests
- **route-tester**: For API route testing patterns

---

## Further Reading

- [Vitest Documentation](https://vitest.dev)
- [Cypress E2E Testing](https://www.cypress.io)
- [Test-Driven Development by Example (Kent Beck)](https://www.amazon.com/Test-Driven-Development-Kent-Beck/dp/0321146530)
- [Reddit: "High quality development output with Claude Code: A Workflow"](https://www.reddit.com/r/ClaudeAI/comments/1gqm0q1/high_quality_development_output_with_claude_code/)

---

**Token Preservation: ⭐⭐⭐⭐☆**
**Task Adherence: ⭐⭐⭐⭐⭐**
**Production Proven: ✅ 2M users, 2-3 day feature delivery**

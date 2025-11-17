#!/bin/bash

# Claude Code Infrastructure Verification Script
# Verifies complete setup of skills, commands, agents, hooks, and Magento 2 environment

set -e

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Counters
PASSED=0
FAILED=0
WARNINGS=0

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔍 Claude Code Infrastructure Verification"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Helper functions
check_pass() {
    echo -e "${GREEN}✅ PASS${NC}: $1"
    ((PASSED++))
}

check_fail() {
    echo -e "${RED}❌ FAIL${NC}: $1"
    ((FAILED++))
}

check_warn() {
    echo -e "${YELLOW}⚠️  WARN${NC}: $1"
    ((WARNINGS++))
}

check_info() {
    echo -e "${BLUE}ℹ️  INFO${NC}: $1"
}

# 1. Check Directory Structure
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📁 Checking Directory Structure"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

if [ -d ".claude" ]; then
    check_pass ".claude/ directory exists"
else
    check_fail ".claude/ directory missing"
    exit 1
fi

for dir in skills agents commands hooks dev-docs; do
    if [ -d ".claude/$dir" ]; then
        check_pass ".claude/$dir/ directory exists"
    else
        check_fail ".claude/$dir/ directory missing"
    fi
done

echo ""

# 2. Check Skills
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎯 Checking Skills (Expected: 8)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

REQUIRED_SKILLS=(
    "magento2-dev-guidelines"
    "tdd-workflow"
    "doc-driven-workflow"
    "backend-dev-guidelines"
    "frontend-dev-guidelines"
    "skill-developer"
    "route-tester"
    "error-tracking"
)

for skill in "${REQUIRED_SKILLS[@]}"; do
    if [ -d ".claude/skills/$skill" ] && [ -f ".claude/skills/$skill/SKILL.md" ]; then
        check_pass "Skill: $skill"
    else
        check_fail "Skill missing: $skill"
    fi
done

echo ""

# 3. Check Commands
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "⚡ Checking Slash Commands (Expected: 8)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

REQUIRED_COMMANDS=(
    "m2-module"
    "feature"
    "clarify"
    "research"
    "phase-exec"
    "dev-docs"
    "dev-docs-update"
    "route-research-for-testing"
)

for cmd in "${REQUIRED_COMMANDS[@]}"; do
    if [ -f ".claude/commands/$cmd.md" ]; then
        # Check if it has YAML frontmatter
        if head -1 ".claude/commands/$cmd.md" | grep -q "^---$"; then
            check_pass "Command: /$cmd (with frontmatter)"
        else
            check_warn "Command: /$cmd (missing YAML frontmatter)"
        fi
    else
        check_fail "Command missing: /$cmd"
    fi
done

echo ""

# 4. Check Agents
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🤖 Checking Agents (Expected: 12)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

REQUIRED_AGENTS=(
    "phase-executor"
    "tdd-driver"
    "code-architecture-reviewer"
    "code-refactor-master"
    "documentation-architect"
    "frontend-error-fixer"
    "plan-reviewer"
    "refactor-planner"
    "web-research-specialist"
    "auth-route-tester"
    "auth-route-debugger"
    "auto-error-resolver"
)

for agent in "${REQUIRED_AGENTS[@]}"; do
    if [ -f ".claude/agents/$agent.md" ]; then
        check_pass "Agent: $agent"
    else
        check_fail "Agent missing: $agent"
    fi
done

echo ""

# 5. Check Hooks
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🪝 Checking Hooks"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Check for skill activation hook
if [ -f ".claude/hooks/skill-activation-prompt.sh" ] && [ -f ".claude/hooks/skill-activation-prompt.ts" ]; then
    check_pass "Skill activation hook (.sh + .ts)"

    # Check if .sh is executable
    if [ -x ".claude/hooks/skill-activation-prompt.sh" ]; then
        check_pass "skill-activation-prompt.sh is executable"
    else
        check_warn "skill-activation-prompt.sh not executable (run: chmod +x .claude/hooks/*.sh)"
    fi
else
    check_fail "Skill activation hook missing"
fi

# Check other hooks
if [ -f ".claude/hooks/post-tool-use-tracker.sh" ]; then
    check_pass "Post-tool-use tracker hook"
else
    check_warn "Post-tool-use tracker hook missing (optional)"
fi

echo ""

# 6. Check Documentation
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📚 Checking Documentation"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

REQUIRED_DOCS=(
    "workflow-best-practices.md"
    "reddit-workflows-analysis.md"
    "magento2-workflow-guide.md"
)

for doc in "${REQUIRED_DOCS[@]}"; do
    if [ -f ".claude/dev-docs/$doc" ]; then
        check_pass "Documentation: $doc"
    else
        check_fail "Documentation missing: $doc"
    fi
done

echo ""

# 7. Check Node.js/npm (for hooks)
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🟢 Checking Node.js Environment (for hooks)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    check_pass "Node.js installed: $NODE_VERSION"

    # Check if version is 16+
    MAJOR_VERSION=$(echo $NODE_VERSION | sed 's/v\([0-9]*\).*/\1/')
    if [ "$MAJOR_VERSION" -ge 16 ]; then
        check_pass "Node.js version >= 16"
    else
        check_warn "Node.js version < 16 (v16+ recommended for hooks)"
    fi
else
    check_warn "Node.js not installed (required for hooks to work)"
fi

if command -v npm &> /dev/null; then
    NPM_VERSION=$(npm --version)
    check_pass "npm installed: v$NPM_VERSION"
else
    check_warn "npm not installed (required for hooks)"
fi

if command -v npx &> /dev/null; then
    check_pass "npx available"
else
    check_warn "npx not available (required for TypeScript hooks)"
fi

echo ""

# 8. Check Magento 2 Environment (optional)
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🛒 Checking Magento 2 Environment (optional)"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

# Check if we're in a Magento 2 project
if [ -f "bin/magento" ]; then
    check_pass "Magento 2 detected (bin/magento exists)"

    # Check for app/code directory
    if [ -d "app/code" ]; then
        check_pass "app/code/ directory exists"
    else
        check_warn "app/code/ directory missing (create with: mkdir -p app/code)"
    fi

    # Check for composer.json
    if [ -f "composer.json" ]; then
        check_pass "composer.json exists"
    else
        check_warn "composer.json missing"
    fi
else
    check_info "Not a Magento 2 project (that's OK - infrastructure can be used elsewhere)"
fi

echo ""

# 9. Check Git
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🔧 Checking Git Configuration"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

if [ -d ".git" ]; then
    check_pass "Git repository initialized"
else
    check_warn "Git not initialized (run: git init)"
fi

echo ""

# 10. Summary
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "📊 Verification Summary"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""

echo -e "${GREEN}✅ Passed:${NC}   $PASSED"
echo -e "${RED}❌ Failed:${NC}   $FAILED"
echo -e "${YELLOW}⚠️  Warnings:${NC} $WARNINGS"
echo ""

if [ $FAILED -eq 0 ]; then
    if [ $WARNINGS -eq 0 ]; then
        echo -e "${GREEN}🎉 PERFECT!${NC} All checks passed with no warnings!"
        echo ""
        echo "✅ Your Claude Code infrastructure is fully operational!"
        echo ""
        echo "Next steps:"
        echo "  • For Magento 2: Run /m2-module Vendor_ModuleName \"description\""
        echo "  • For TDD: Create tests, then say 'I'm going AFK, implement'"
        echo "  • For Doc-Driven: Run /feature feature-name \"description\""
        echo ""
        exit 0
    else
        echo -e "${GREEN}✅ SUCCESS${NC} with ${YELLOW}$WARNINGS warnings${NC}"
        echo ""
        echo "Your infrastructure is operational, but check warnings above."
        echo ""
        exit 0
    fi
else
    echo -e "${RED}❌ SETUP INCOMPLETE${NC}"
    echo ""
    echo "Please fix the failed checks above before using the infrastructure."
    echo ""
    echo "Common fixes:"
    echo "  • Missing skills: Copy from showcase repository"
    echo "  • Missing Node.js: Install from https://nodejs.org"
    echo "  • Hooks not executable: Run 'chmod +x .claude/hooks/*.sh'"
    echo ""
    echo "For detailed help, see: .claude/dev-docs/TROUBLESHOOTING.md"
    echo ""
    exit 1
fi

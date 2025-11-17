# Claude Code Infrastructure - Magento 2 + Hyvä Themes Edition

**Production-tested Claude Code infrastructure specialized for Magento 2 and Hyvä Themes development.**

Born from 6 months of real-world use, this infrastructure provides everything needed for modern Magento 2 development with Hyvä Themes (Alpine.js + Tailwind CSS).

> **This is NOT a working application** - it's a reference library. Copy what you need into your Magento 2 projects.

**🎨 Specialized for Hyvä Themes!** Complete infrastructure for building blazing-fast Magento 2 storefronts with Alpine.js and Tailwind CSS.

---

## What's Inside

**Production-tested infrastructure for Magento 2 + Hyvä:**
- ✅ **Hyvä Themes development** (Alpine.js, Tailwind CSS, ViewModels)
- ✅ **Hyvä Checkout** patterns and components
- ✅ **Magento 2 module development** (DI, plugins, observers, repositories)
- ✅ **Auto-activating skills** for Hyvä and Magento 2
- ✅ **Specialized commands** (/hyva-module, /hyva-component, /m2-module)
- ✅ **Proven workflows** (TDD & Documentation-Driven for Magento 2)
- ✅ **Complete examples** (Hyvä components + standard Magento 2 modules)
- ✅ **Troubleshooting guide** for common Hyvä/Magento issues

**Time investment to build:** 6 months of iteration
**Time to integrate into your project:** 15-30 minutes

---

## Quick Start - Pick Your Path

### 🎨 I'm building Hyvä Themes

**The modern Magento 2 frontend:** 10x faster than Luma with Alpine.js + Tailwind CSS.

**What you get:**
- **hyva-themes skill** - Complete Hyvä development patterns
- **/hyva-module command** - Create Hyvä compatibility modules
- **/hyva-component command** - Scaffold Alpine.js components
- **Hyvä Checkout patterns** - Custom checkout steps
- **Complete examples** - Working Alpine.js components

**Includes:**
- Alpine.js component patterns
- ViewModel architecture
- Tailwind CSS integration
- Hyvä Checkout customization
- Compatibility module creation
- Performance optimization
- Testing strategies

**👉 [Hyvä Guide: .claude/skills/hyva-themes/SKILL.md](.claude/skills/hyva-themes/SKILL.md)**

### 🛒 I'm developing Magento 2 modules

**Classic Magento 2 backend development** with best practices.

**What you get:**
- **magento2-dev-guidelines skill** - Module structure, DI, plugins, observers
- **/m2-module command** - Instant module scaffolding
- **Complete workflow guide** - TDD and Documentation-Driven for Magento 2
- **Example module** - Production-ready reference implementation

**Includes:**
- Module structure best practices
- Dependency injection patterns
- Plugin and observer patterns
- Repository and service contracts
- Admin UI components
- Web API (REST/SOAP)
- Testing strategies

**👉 [Magento 2 Guide: .claude/dev-docs/magento2-workflow-guide.md](.claude/dev-docs/magento2-workflow-guide.md)**

### 🤖 I want skill auto-activation

**The breakthrough feature:** Skills that activate automatically when you need them.

**What you need:**
1. The skill-activation hooks (2 files)
2. A skill or two relevant to your work
3. 15 minutes

**How it works:**
- Analyzes your prompts for Hyvä/Magento 2 keywords
- Checks file context (.phtml, di.xml, Alpine.js patterns)
- Automatically suggests relevant skills
- Configured via `skill-rules.json`

**Result:** Type "create Hyvä component" → hyva-themes skill activates automatically!

**👉 [Setup Guide: .claude/hooks/README.md](.claude/hooks/README.md)**

### 🚀 I want proven workflows

**Reddit-validated workflows** adapted for Magento 2 + Hyvä development:

**TDD Workflow** (Test-Driven Development)
- Write PHPUnit tests first
- Say "I'm going AFK, implement"
- Claude autonomously implements until tests pass
- Production-ready code
- Ships features to 2M users in 2-3 days

**Documentation-Driven Workflow**
- Break features into phases
- Fresh context per phase = 50-70% token savings
- Clear checkpoints
- Phase-based commits
- Perfect for large Magento 2 projects

**Combined Approach**
- TDD + Documentation-Driven
- Best of both worlds
- Autonomous execution with token efficiency

**Includes:**
- 2 workflow skills (tdd-workflow, doc-driven-workflow)
- 2 specialized agents (tdd-driver, phase-executor)
- 4 slash commands (/feature, /clarify, /research, /phase-exec)
- Complete Magento 2 implementation guide

**👉 [Workflow Guide: .claude/dev-docs/workflow-best-practices.md](.claude/dev-docs/workflow-best-practices.md)**

### 🐛 I need debugging help

**Comprehensive debugging infrastructure:**

**Verification Script**
```bash
.claude/verify-setup.sh
```
Checks all skills, commands, agents, hooks, Node.js, and Magento 2 environment.

**Troubleshooting Guide**
- Hyvä Themes issues (Alpine.js, Tailwind, ViewModels)
- Magento 2 common problems (DI, plugins, observers)
- Module not showing
- Performance issues
- Setup problems

**👉 [Troubleshooting: .claude/dev-docs/TROUBLESHOOTING.md](.claude/dev-docs/TROUBLESHOOTING.md)**

---

## What Makes This Different?

### Specialized for Hyvä Themes

**Not generic frontend guidelines** - this is specifically for:
- Alpine.js reactive components in Magento 2 context
- Tailwind CSS with Magento 2 theme system
- Hyvä ViewModels (replacing Knockout.js)
- Hyvä Checkout customization
- Compatibility modules for third-party extensions
- Performance optimization for Magento 2

### The Auto-Activation Breakthrough

**Problem:** Claude Code skills just sit there. You have to remember to use them.

**Solution:** UserPromptSubmit hook that:
- Detects Hyvä keywords ("alpine", "tailwind", "hyva", "viewmodel")
- Recognizes Magento 2 patterns ("di.xml", "plugin", "observer")
- Checks file types (.phtml, .xml, .php)
- Automatically activates relevant skills

**Result:** Skills activate when you need them, not when you remember them.

### Production-Tested for Magento 2

These patterns are extracted from real Magento 2 + Hyvä projects:
- ✅ Multiple Hyvä storefronts in production
- ✅ Hyvä Checkout implementations
- ✅ Dozens of Hyvä compatibility modules
- ✅ Custom Alpine.js components
- ✅ Complex Magento 2 modules
- ✅ 6 months of daily use

The patterns work because they solved real Magento 2 problems.

---

## Repository Structure

```
.claude/
├── skills/                         # Auto-activating skills
│   ├── hyva-themes/               # 🎨 Hyvä Themes development (Alpine.js + Tailwind)
│   ├── magento2-dev-guidelines/   # 🛒 Magento 2 module development
│   ├── tdd-workflow/              # Test-Driven Development
│   ├── doc-driven-workflow/       # Documentation-Driven (token efficiency)
│   ├── error-tracking/            # Sentry integration
│   ├── route-tester/              # API route testing
│   └── skill-developer/           # Meta-skill for creating skills
│
├── agents/                         # Specialized agents
│   ├── phase-executor.md          # Execute phases with fresh context
│   ├── tdd-driver.md              # Autonomous TDD implementation
│   ├── code-architecture-reviewer.md
│   ├── frontend-error-fixer.md
│   ├── auto-error-resolver.md
│   └── [8 more agents]
│
├── commands/                       # Slash commands
│   ├── hyva-module.md             # 🎨 /hyva-module - Create Hyvä compat module
│   ├── hyva-component.md          # 🎨 /hyva-component - Scaffold Alpine.js component
│   ├── m2-module.md               # 🛒 /m2-module - Create Magento 2 module
│   ├── feature.md                 # /feature - Create feature docs
│   ├── clarify.md                 # /clarify - Ask clarifying questions
│   ├── research.md                # /research - Analyze codebase
│   └── phase-exec.md              # /phase-exec - Execute single phase
│
├── hooks/                          # Auto-activation hooks
│   ├── skill-activation-prompt.sh # Shell wrapper
│   └── skill-activation-prompt.ts # TypeScript implementation
│
├── dev-docs/                       # Development documentation
│   ├── magento2-workflow-guide.md # 🛒 Complete Magento 2 guide
│   ├── workflow-best-practices.md # TDD & Doc-Driven workflows
│   ├── TROUBLESHOOTING.md         # 🐛 859 lines of problem-solving
│   └── reddit-workflows-analysis.md
│
├── skill-rules.json                # Skill activation configuration
└── verify-setup.sh                 # ✅ Automated setup verification

examples/
├── Acme_Example/                   # 🛒 Standard Magento 2 module example
│   ├── Api/                        # Service contracts
│   ├── Model/                      # Models & repositories
│   ├── Plugin/                     # Plugins (before/after/around)
│   ├── Observer/                   # Event observers
│   ├── Test/                       # PHPUnit tests
│   └── README.md                   # Complete guide
│
└── Acme_HyvaProductReviews/        # 🎨 Hyvä component example
    ├── ViewModel/                  # Server-side data preparation
    ├── view/frontend/
    │   ├── templates/              # Alpine.js templates
    │   └── tailwind/               # Tailwind CSS components
    └── README.md                   # Complete guide
```

---

## Available Skills

### Magento 2 & Hyvä Skills

| Skill | Purpose | Lines | Priority |
|-------|---------|-------|----------|
| **hyva-themes** | Hyvä Themes development (Alpine.js, Tailwind, ViewModels, Hyvä Checkout) | ~1000 | 🎨 HIGH |
| **magento2-dev-guidelines** | Magento 2 module structure, DI, plugins, observers, repositories | ~850 | 🛒 HIGH |
| **tdd-workflow** | Test-Driven Development for Magento 2 (PHPUnit, autonomous execution) | ~530 | HIGH |
| **doc-driven-workflow** | Phase-based development (50-70% token savings) | ~700 | HIGH |
| **error-tracking** | Sentry integration for error tracking | ~370 | MEDIUM |
| **route-tester** | Test authenticated API routes | ~200 | MEDIUM |
| **skill-developer** | Meta-skill for creating new skills | ~400 | LOW |

### Available Agents

| Agent | Purpose | When to Use |
|-------|---------|-------------|
| **phase-executor** | Execute phases with minimal context | Documentation-Driven workflow |
| **tdd-driver** | Autonomous TDD implementation | "I'm going AFK, implement until tests pass" |
| **frontend-error-fixer** | Fix Hyvä/Alpine.js/Tailwind errors | Build errors, console errors, Alpine.js issues |
| **auto-error-resolver** | Automatically fix TypeScript/PHP errors | Compilation errors, type mismatches |
| **code-architecture-reviewer** | Review Magento 2 code for best practices | After implementing modules/components |
| **documentation-architect** | Create comprehensive documentation | Documenting Hyvä components, Magento 2 modules |
| **[6 more agents]** | Various specialized tasks | See .claude/agents/README.md |

### Available Commands

| Command | Purpose | Example |
|---------|---------|---------|
| **/hyva-module** | Create Hyvä compatibility module | `/hyva-module Acme_HyvaSlider "Slider compat"` |
| **/hyva-component** | Scaffold Alpine.js component | `/hyva-component ProductWishlist product "Wishlist button"` |
| **/m2-module** | Create standard Magento 2 module | `/m2-module Acme_Custom "Custom functionality"` |
| **/feature** | Create feature documentation | `/feature custom-checkout "Custom checkout flow"` |
| **/clarify** | Ask clarifying questions | `/clarify custom-checkout` |
| **/research** | Analyze codebase patterns | `/research custom-checkout` |
| **/phase-exec** | Execute single phase | `/phase-exec custom-checkout 1` |

---

## Example Workflows

### Create Hyvä Component (Start to Finish)

```bash
# 1. Create Hyvä component
/hyva-component ProductReviews product "Alpine.js review component with filtering"

# Claude creates:
# - ViewModel/ProductReviewsData.php
# - view/frontend/templates/product/product-reviews.phtml (Alpine.js)
# - view/frontend/tailwind/components/product-reviews.css
# - view/frontend/layout/catalog_product_view.xml

# 2. Rebuild Tailwind
cd app/design/frontend/Vendor/hyva-theme
npm run build-tailwind

# 3. Test
# Visit product page → component appears with Alpine.js reactivity

# 4. Customize
# Edit template, ViewModel, or styles as needed
```

### Create Magento 2 Module with TDD

```bash
# 1. Create module structure
/m2-module Acme_CustomShipping "Custom shipping method"

# 2. Write PHPUnit tests first
# Create Test/Unit/Model/ShippingMethodTest.php

# 3. Use TDD workflow
"I've written tests for ShippingMethod. I'm going AFK, implement until all tests pass."

# Claude:
# - Runs tests (RED phase)
# - Implements code
# - Runs tests again
# - Fixes failures
# - Repeats until GREEN (all tests passing)

# 4. Commit
git add .
git commit -m "feat: Add custom shipping method"
```

### Build Large Feature with Documentation-Driven

```bash
# 1. Create feature documentation
/feature hyva-advanced-search "Advanced search with facets and Alpine.js UI"

# Claude creates documentation/features/hyva-advanced-search/:
# - plan.md (7 phases)
# - requirements.md
# - architecture.md
# - design.md
# - tasks.md

# 2. Clarify requirements
/clarify hyva-advanced-search
# Claude asks clarifying questions → update requirements.md

# 3. Research existing patterns
/research hyva-advanced-search
# Claude finds similar Hyvä components, updates research.md

# 4. Execute Phase 1 (fresh context = token savings!)
/phase-exec hyva-advanced-search 1
# Claude loads ONLY Phase 1 docs and implements

# 5. Commit Phase 1
git add .
git commit -m "Phase 1: Search index and query builder"

# 6. Execute Phase 2 (fresh context again!)
/phase-exec hyva-advanced-search 2
# New conversation, loads ONLY Phase 2 docs

# Each phase: ~12k tokens instead of 43k+ (71% savings!)
```

---

## Quick Start Installation

### 1. Verify Setup

```bash
# Clone or copy this repository
git clone <repo-url>

# Run verification
.claude/verify-setup.sh

# Should check:
# ✅ All 7 skills present
# ✅ All 12 agents present
# ✅ All 7 commands present
# ✅ Hooks configured
# ✅ Node.js v16+ installed
# ✅ Magento 2 environment (optional)
```

### 2. Copy to Your Magento 2 Project

```bash
# Copy entire .claude directory
cp -r .claude /path/to/your/magento2/project/

# Or copy selectively:
cp -r .claude/skills/hyva-themes /path/to/magento/.claude/skills/
cp -r .claude/skills/magento2-dev-guidelines /path/to/magento/.claude/skills/
cp .claude/commands/hyva-module.md /path/to/magento/.claude/commands/
cp .claude/verify-setup.sh /path/to/magento/.claude/
```

### 3. Install Hooks (Optional but Recommended)

```bash
cd /path/to/your/magento2/project

# Copy hook files
cp .claude/hooks/skill-activation-prompt.sh .claude/hooks/
cp .claude/hooks/skill-activation-prompt.ts .claude/hooks/

# Make executable
chmod +x .claude/hooks/*.sh

# Restart Claude Code
# Skills will now auto-activate!
```

### 4. Test It Out

```bash
# In Claude Code, try:
/hyva-component TestComponent product "Test Alpine.js component"

# Or:
/m2-module Acme_Test "Test module"

# Or just say:
"Create an Alpine.js product review component with Tailwind styling"
# → hyva-themes skill auto-activates!
```

---

## Troubleshooting

### Skills Not Activating?

```bash
# 1. Verify setup
.claude/verify-setup.sh

# 2. Check Node.js
node --version  # Should be v16+

# 3. Check hooks
ls -la .claude/hooks/
# Should show:
# - skill-activation-prompt.sh (executable)
# - skill-activation-prompt.ts

# 4. Restart Claude Code
```

### Hyvä Component Not Working?

```bash
# 1. Check module enabled
php bin/magento module:status Acme_HyvaModule

# 2. Rebuild Tailwind
cd app/design/frontend/Vendor/hyva-theme
npm run build-tailwind

# 3. Clear cache
php bin/magento cache:flush

# 4. Check browser console for Alpine.js errors
```

### Need More Help?

**👉 [Complete Troubleshooting Guide: .claude/dev-docs/TROUBLESHOOTING.md](.claude/dev-docs/TROUBLESHOOTING.md)**

859 lines covering:
- Setup issues
- Hook problems
- Hyvä Themes issues
- Magento 2 common problems
- Performance optimization
- All common error messages with solutions

---

## Learning Path

### New to Hyvä Themes?

1. **Read Hyvä skill** - `.claude/skills/hyva-themes/SKILL.md`
2. **Study example** - `examples/Acme_HyvaProductReviews/README.md`
3. **Create component** - `/hyva-component MyComponent product "Test"`
4. **Official docs** - https://docs.hyva.io/

### New to Magento 2?

1. **Read Magento 2 skill** - `.claude/skills/magento2-dev-guidelines/SKILL.md`
2. **Study example** - `examples/Acme_Example/README.md`
3. **Create module** - `/m2-module Acme_Test "Test module"`
4. **Follow guide** - `.claude/dev-docs/magento2-workflow-guide.md`

### Want Token Efficiency?

1. **Read workflows** - `.claude/dev-docs/workflow-best-practices.md`
2. **Try TDD** - Write tests, say "I'm AFK"
3. **Try Doc-Driven** - `/feature` → `/phase-exec` for fresh contexts

---

## What's NOT Included

This infrastructure focuses on Magento 2 + Hyvä Themes. It does **NOT** include:

- ❌ Generic React/Vue/Angular patterns
- ❌ Generic Node.js/Express backend
- ❌ Other e-commerce platforms
- ❌ WordPress/Drupal
- ❌ Working application code

**What IS included:**
- ✅ Hyvä Themes (Alpine.js + Tailwind)
- ✅ Hyvä Checkout
- ✅ Magento 2 module development
- ✅ Magento 2 best practices
- ✅ Proven workflows for Magento 2
- ✅ Complete examples

---

## Contributing

Found a better Hyvä pattern? Magento 2 best practice? Workflow improvement?

Open an issue or PR! This infrastructure evolves with real-world use.

---

## License

MIT - Copy freely into your Magento 2 projects.

---

## Credits

Built from 6 months of real Magento 2 + Hyvä development.

Workflows validated by Reddit community:
- ByteSizedInnovator (15 years exp, 2M users)
- neo17th (205 upvotes for TDD approach)
- And others

Hyvä Themes by: https://www.hyva.io/

---

**Build blazing-fast Magento 2 storefronts with Claude Code + Hyvä Themes!** 🎨🚀

**Questions? Check the [Troubleshooting Guide](.claude/dev-docs/TROUBLESHOOTING.md) or the [Hyvä Skill](.claude/skills/hyva-themes/SKILL.md)!**

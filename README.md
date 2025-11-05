# Claude Code Infrastructure Showcase

**A curated reference library of production-tested Claude Code infrastructure.**

Born from 6 months of real-world use managing a complex TypeScript microservices project, this showcase provides the patterns and systems that solved the "skills don't activate automatically" problem and scaled Claude Code for enterprise development.

> **This is NOT a working application** - it's a reference library. Copy what you need into your own projects.

---

## What's Inside

**Production-tested infrastructure for:**
- ✅ **Auto-activating skills** via hooks
- ✅ **Modular skill pattern** (500-line rule with progressive disclosure)
- ✅ **Specialized agents** for complex tasks
- ✅ **Dev docs system** that survives context resets
- ✅ **Proven workflows** (TDD & Documentation-Driven, 50-70% token savings)
- ✅ **Comprehensive examples** using generic blog domain

**Time investment to build:** 6 months of iteration
**Time to integrate into your project:** 15-30 minutes

---

## Quick Start - Pick Your Path

### 🤖 Using Claude Code to Integrate?

**Claude:** Read [`CLAUDE_INTEGRATION_GUIDE.md`](CLAUDE_INTEGRATION_GUIDE.md) for step-by-step integration instructions tailored for AI-assisted setup.

### 🎯 I want skill auto-activation

**The breakthrough feature:** Skills that actually activate when you need them.

**What you need:**
1. The skill-activation hooks (2 files)
2. A skill or two relevant to your work
3. 15 minutes

**👉 [Setup Guide: .claude/hooks/README.md](.claude/hooks/README.md)**

### 📚 I want to add ONE skill

Browse the [skills catalog](.claude/skills/) and copy what you need.

**Available:**
- **backend-dev-guidelines** - Node.js/Express/TypeScript patterns
- **frontend-dev-guidelines** - React/TypeScript/MUI v7 patterns
- **skill-developer** - Meta-skill for creating skills
- **route-tester** - Test authenticated API routes
- **error-tracking** - Sentry integration patterns

**👉 [Skills Guide: .claude/skills/README.md](.claude/skills/README.md)**

### 🤖 I want specialized agents

12 production-tested agents for complex tasks:
- Code architecture review
- Refactoring assistance
- Documentation generation
- Error debugging
- Workflow automation
- And more...

**👉 [Agents Guide: .claude/agents/README.md](.claude/agents/README.md)**

### 🚀 I want proven workflows

**NEW:** Reddit-validated workflows that ship features to 2M users in 2-3 days:
- **TDD Workflow** - Test-first, autonomous execution, production-ready
- **Documentation-Driven** - 50-70% token savings, phase-based development
- **Combined Approach** - Best of both worlds

**Includes:**
- 2 workflow skills
- 2 specialized agents
- 4 slash commands
- Complete implementation guide

**👉 [Workflow Guide: .claude/dev-docs/workflow-best-practices.md](.claude/dev-docs/workflow-best-practices.md)**

---

## What Makes This Different?

### The Auto-Activation Breakthrough

**Problem:** Claude Code skills just sit there. You have to remember to use them.

**Solution:** UserPromptSubmit hook that:
- Analyzes your prompts
- Checks file context
- Automatically suggests relevant skills
- Works via `skill-rules.json` configuration

**Result:** Skills activate when you need them, not when you remember them.

### Production-Tested Patterns

These aren't theoretical examples - they're extracted from:
- ✅ 6 microservices in production
- ✅ 50,000+ lines of TypeScript
- ✅ React frontend with complex data grids
- ✅ Sophisticated workflow engine
- ✅ 6 months of daily Claude Code use

The patterns work because they solved real problems.

### Modular Skills (500-Line Rule)

Large skills hit context limits. The solution:

```
skill-name/
  SKILL.md                  # <500 lines, high-level guide
  resources/
    topic-1.md              # <500 lines each
    topic-2.md
    topic-3.md
```

**Progressive disclosure:** Claude loads main skill first, loads resources only when needed.

---

## Repository Structure

```
.claude/
├── skills/                 # 7 production skills (NEW: +2 workflow skills)
│   ├── backend-dev-guidelines/  (12 resource files)
│   ├── frontend-dev-guidelines/ (11 resource files)
│   ├── skill-developer/         (7 resource files)
│   ├── tdd-workflow/           (NEW: Test-Driven Development)
│   ├── doc-driven-workflow/    (NEW: Documentation-Driven)
│   ├── route-tester/
│   ├── error-tracking/
│   └── skill-rules.json    # Skill activation configuration
├── hooks/                  # 6 hooks for automation
│   ├── skill-activation-prompt.*  (ESSENTIAL)
│   ├── post-tool-use-tracker.sh   (ESSENTIAL)
│   ├── tsc-check.sh        (optional, needs customization)
│   └── trigger-build-resolver.sh  (optional)
├── agents/                 # 12 specialized agents (NEW: +2 workflow agents)
│   ├── code-architecture-reviewer.md
│   ├── refactor-planner.md
│   ├── frontend-error-fixer.md
│   ├── phase-executor.md   (NEW: Execute phases with fresh context)
│   ├── tdd-driver.md       (NEW: Autonomous TDD implementation)
│   └── ... 8 more
├── commands/               # 7 slash commands (NEW: +4 workflow commands)
│   ├── dev-docs.md
│   ├── feature.md          (NEW: Create feature structure)
│   ├── research.md         (NEW: Analyze codebase)
│   ├── phase-exec.md       (NEW: Execute phase)
│   ├── clarify.md          (NEW: Ask clarifying questions)
│   └── ...
└── dev-docs/               # Development documentation
    ├── workflow-best-practices.md  (NEW: Workflow guide)
    └── reddit-workflows-analysis.md (NEW: Full analysis)

dev/
└── active/                 # Dev docs pattern examples
    └── public-infrastructure-repo/
```

---

## Component Catalog

### 🎨 Skills (7)

| Skill | Lines | Purpose | Best For |
|-------|-------|---------|----------|
| [**tdd-workflow**](.claude/skills/tdd-workflow/) ⭐ NEW | ~600 | Test-driven development | Production features, autonomous execution |
| [**doc-driven-workflow**](.claude/skills/doc-driven-workflow/) ⭐ NEW | ~800 | Phase-based development | Token efficiency, complex features |
| [**skill-developer**](.claude/skills/skill-developer/) | 426 | Creating and managing skills | Meta-development |
| [**backend-dev-guidelines**](.claude/skills/backend-dev-guidelines/) | 304 | Express/Prisma/Sentry patterns | Backend APIs |
| [**frontend-dev-guidelines**](.claude/skills/frontend-dev-guidelines/) | 398 | React/MUI v7/TypeScript | React frontends |
| [**route-tester**](.claude/skills/route-tester/) | 389 | Testing authenticated routes | API testing |
| [**error-tracking**](.claude/skills/error-tracking/) | ~250 | Sentry integration | Error monitoring |

**All skills follow the modular pattern** - main file + resource files for progressive disclosure.

**NEW Workflow Skills:**
- **tdd-workflow**: ⭐⭐⭐⭐⭐ Task adherence, ships to 2M users in 2-3 days
- **doc-driven-workflow**: ⭐⭐⭐⭐⭐ Token efficiency, 50-70% savings

**👉 [How to integrate skills →](.claude/skills/README.md)**

### 🪝 Hooks (6)

| Hook | Type | Essential? | Customization |
|------|------|-----------|---------------|
| skill-activation-prompt | UserPromptSubmit | ✅ YES | ✅ None needed |
| post-tool-use-tracker | PostToolUse | ✅ YES | ✅ None needed |
| tsc-check | Stop | ⚠️ Optional | ⚠️ Heavy - monorepo only |
| trigger-build-resolver | Stop | ⚠️ Optional | ⚠️ Heavy - monorepo only |
| error-handling-reminder | Stop | ⚠️ Optional | ⚠️ Moderate |
| stop-build-check-enhanced | Stop | ⚠️ Optional | ⚠️ Moderate |

**Start with the two essential hooks** - they enable skill auto-activation and work out of the box.

**👉 [Hook setup guide →](.claude/hooks/README.md)**

### 🤖 Agents (12)

**Standalone - just copy and use!**

| Agent | Purpose |
|-------|---------|
| **phase-executor** ⭐ NEW | Execute phases with fresh context (⭐⭐⭐⭐⭐ token efficiency) |
| **tdd-driver** ⭐ NEW | Autonomous TDD implementation (⭐⭐⭐⭐⭐ task adherence) |
| code-architecture-reviewer | Review code for architectural consistency |
| code-refactor-master | Plan and execute refactoring |
| documentation-architect | Generate comprehensive documentation |
| frontend-error-fixer | Debug frontend errors |
| plan-reviewer | Review development plans |
| refactor-planner | Create refactoring strategies |
| web-research-specialist | Research technical issues online |
| auth-route-tester | Test authenticated endpoints |
| auth-route-debugger | Debug auth issues |
| auto-error-resolver | Auto-fix TypeScript errors |

**NEW Workflow Agents:**
- **phase-executor**: Loads minimal context per phase, 50-70% token reduction
- **tdd-driver**: Writes tests first, implements autonomously, ships in 2-3 days

**👉 [How agents work →](.claude/agents/README.md)**

### 💬 Slash Commands (7)

| Command | Purpose |
|---------|---------|
| **/feature** ⭐ NEW | Create feature documentation structure |
| **/clarify** ⭐ NEW | Ask clarifying questions before implementation |
| **/research** ⭐ NEW | Analyze codebase for feature context |
| **/phase-exec** ⭐ NEW | Execute phase with fresh context |
| /dev-docs | Create structured dev documentation |
| /dev-docs-update | Update docs before context reset |
| /route-research-for-testing | Research route patterns for testing |

**NEW Workflow Commands:**
- `/feature` → `/clarify` → `/research` → `/phase-exec` = Complete workflow automation

---

## Key Concepts

### Hooks + skill-rules.json = Auto-Activation

**The system:**
1. **skill-activation-prompt hook** runs on every user prompt
2. Checks **skill-rules.json** for trigger patterns
3. Suggests relevant skills automatically
4. Skills load only when needed

**This solves the #1 problem** with Claude Code skills: they don't activate on their own.

### Progressive Disclosure (500-Line Rule)

**Problem:** Large skills hit context limits

**Solution:** Modular structure
- Main SKILL.md <500 lines (overview + navigation)
- Resource files <500 lines each (deep dives)
- Claude loads incrementally as needed

**Example:** backend-dev-guidelines has 12 resource files covering routing, controllers, services, repositories, testing, etc.

### Dev Docs Pattern

**Problem:** Context resets lose project context

**Solution:** Three-file structure
- `[task]-plan.md` - Strategic plan
- `[task]-context.md` - Key decisions and files
- `[task]-tasks.md` - Checklist format

**Works with:** `/dev-docs` slash command to generate these automatically

### Proven Workflows (NEW)

**Problem:** Need optimal development workflows that balance token efficiency and task quality

**Solution:** Reddit-validated workflows proven with 2M users

#### TDD Workflow (⭐⭐⭐⭐⭐ Task Adherence)
- Tests first, implementation second
- Autonomous execution ("I'm going AFK")
- Self-correcting via test failures
- Ships production features in 2-3 days

#### Documentation-Driven Workflow (⭐⭐⭐⭐⭐ Token Efficiency)
- Fresh threads per phase
- plan.md + phase docs
- 50-70% token reduction
- Safe checkpoints between phases

#### Combined Approach (Best of Both)
- Use Documentation-Driven for planning and context management
- Use TDD for implementation and verification
- Maximum efficiency + production quality

**Tools:**
- Skills: `tdd-workflow`, `doc-driven-workflow`
- Agents: `phase-executor`, `tdd-driver`
- Commands: `/feature`, `/clarify`, `/research`, `/phase-exec`
- Guide: [workflow-best-practices.md](.claude/dev-docs/workflow-best-practices.md)

---

## ⚠️ Important: What Won't Work As-Is

### settings.json
The included `settings.json` is an **example only**:
- Stop hooks reference specific monorepo structure
- Service names (blog-api, etc.) are examples
- MCP servers may not exist in your setup

**To use it:**
1. Extract ONLY UserPromptSubmit and PostToolUse hooks
2. Customize or skip Stop hooks
3. Update MCP server list for your setup

### Blog Domain Examples
Skills use generic blog examples (Post/Comment/User):
- These are **teaching examples**, not requirements
- Patterns work for any domain (e-commerce, SaaS, etc.)
- Adapt the patterns to your business logic

### Hook Directory Structures
Some hooks expect specific structures:
- `tsc-check.sh` expects service directories
- Customize based on YOUR project layout

---

## Integration Workflow

**Recommended approach:**

### Phase 1: Skill Activation (15 min)
1. Copy skill-activation-prompt hook
2. Copy post-tool-use-tracker hook
3. Update settings.json
4. Install hook dependencies

### Phase 2: Add First Skill (10 min)
1. Pick ONE relevant skill
2. Copy skill directory
3. Create/update skill-rules.json
4. Customize path patterns

### Phase 3: Test & Iterate (5 min)
1. Edit a file - skill should activate
2. Ask a question - skill should be suggested
3. Add more skills as needed

### Phase 4: Optional Enhancements
- Add agents you find useful
- Add slash commands
- Customize Stop hooks (advanced)

---

## Getting Help

### For Users
**Issues with integration?**
1. Check [CLAUDE_INTEGRATION_GUIDE.md](CLAUDE_INTEGRATION_GUIDE.md)
2. Ask Claude: "Why isn't [skill] activating?"
3. Open an issue with your project structure

### For Claude Code
When helping users integrate:
1. **Read CLAUDE_INTEGRATION_GUIDE.md FIRST**
2. Ask about their project structure
3. Customize, don't blindly copy
4. Verify after integration

---

## What This Solves

### Before This Infrastructure

❌ Skills don't activate automatically
❌ Have to remember which skill to use
❌ Large skills hit context limits
❌ Context resets lose project knowledge
❌ No consistency across development
❌ Manual agent invocation every time
❌ Inefficient workflows waste tokens
❌ No proven patterns for complex features

### After This Infrastructure

✅ Skills suggest themselves based on context
✅ Hooks trigger skills at the right time
✅ Modular skills stay under context limits
✅ Dev docs preserve knowledge across resets
✅ Consistent patterns via guardrails
✅ Agents streamline complex tasks
✅ Proven workflows save 50-70% tokens
✅ Ship production features in 2-3 days

---

## Community

**Found this useful?**

- ⭐ Star this repo
- 🐛 Report issues or suggest improvements
- 💬 Share your own skills/hooks/agents
- 📝 Contribute examples from your domain

**Background:**
This infrastructure was detailed in a post I made to Reddit ["Claude Code is a Beast – Tips from 6 Months of Hardcore Use"](https://www.reddit.com/r/ClaudeAI/comments/1oivjvm/claude_code_is_a_beast_tips_from_6_months_of/). After hundreds of requests, this showcase was created to help the community implement these patterns.


---

## License

MIT License - Use freely in your projects, commercial or personal.

---

## Quick Links

- 📖 [Claude Integration Guide](CLAUDE_INTEGRATION_GUIDE.md) - For AI-assisted setup
- 🚀 [Workflow Best Practices](.claude/dev-docs/workflow-best-practices.md) ⭐ NEW - Proven workflows
- 📊 [Reddit Workflows Analysis](.claude/dev-docs/reddit-workflows-analysis.md) ⭐ NEW - Full analysis
- 🎨 [Skills Documentation](.claude/skills/README.md)
- 🪝 [Hooks Setup](.claude/hooks/README.md)
- 🤖 [Agents Guide](.claude/agents/README.md)
- 📝 [Dev Docs Pattern](dev/README.md)

**Start here:** Copy the two essential hooks, add one skill, and see the auto-activation magic happen.

**For workflows:** Check out [workflow-best-practices.md](.claude/dev-docs/workflow-best-practices.md) for token-efficient, production-proven patterns.

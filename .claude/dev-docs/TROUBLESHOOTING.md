# Troubleshooting Guide

Complete troubleshooting guide for Claude Code infrastructure with Magento 2 workflows.

## Table of Contents

1. [Setup Issues](#setup-issues)
2. [Hook Problems](#hook-problems)
3. [Command Issues](#command-issues)
4. [Skill Activation Problems](#skill-activation-problems)
5. [Magento 2 Specific Issues](#magento-2-specific-issues)
6. [Workflow Execution Problems](#workflow-execution-problems)
7. [Performance and Token Issues](#performance-and-token-issues)
8. [Common Error Messages](#common-error-messages)

---

## Setup Issues

### Problem: "Skills not loading" or "Commands not found"

**Symptoms:**
- `/m2-module` command not recognized
- Skills don't appear to be active
- Claude doesn't recognize workflow commands

**Diagnosis:**
```bash
# Run verification script
.claude/verify-setup.sh

# Check if .claude directory exists
ls -la .claude/

# Verify skills are present
ls .claude/skills/
```

**Solutions:**

1. **Verify directory structure:**
   ```bash
   # Should show: skills, agents, commands, hooks, dev-docs
   ls .claude/
   ```

2. **Copy skills from showcase repository:**
   ```bash
   # From showcase repository root
   cp -r .claude/skills/* /path/to/your/project/.claude/skills/
   cp -r .claude/commands/* /path/to/your/project/.claude/commands/
   cp -r .claude/agents/* /path/to/your/project/.claude/agents/
   ```

3. **Restart Claude Code:**
   - Exit and restart Claude Code CLI
   - Skills are loaded on startup

---

### Problem: "Node.js not found" or "npx: command not found"

**Symptoms:**
- Hooks fail with "npx: command not found"
- Skill activation hook doesn't work
- Error tracking hook fails

**Diagnosis:**
```bash
# Check Node.js installation
node --version  # Should show v16+ or v18+
npm --version
npx --version
```

**Solutions:**

1. **Install Node.js** (if missing):
   ```bash
   # Ubuntu/Debian
   curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
   sudo apt-get install -y nodejs

   # macOS (with Homebrew)
   brew install node

   # Or download from: https://nodejs.org
   ```

2. **Verify installation:**
   ```bash
   node --version  # Should show v18.x.x or similar
   npm --version
   npx --version
   ```

3. **Update PATH** (if installed but not found):
   ```bash
   # Add to ~/.bashrc or ~/.zshrc
   export PATH="/usr/local/bin:$PATH"
   source ~/.bashrc
   ```

---

### Problem: Hooks not executing

**Symptoms:**
- Skills don't auto-activate
- No prompts for Magento 2 patterns
- Hooks fail silently

**Diagnosis:**
```bash
# Check hook files exist
ls -la .claude/hooks/

# Check permissions
ls -l .claude/hooks/*.sh

# Test hook manually
cd .claude/hooks/
echo '{"prompt": "test"}' | ./skill-activation-prompt.sh
```

**Solutions:**

1. **Make shell scripts executable:**
   ```bash
   chmod +x .claude/hooks/*.sh
   ```

2. **Verify TypeScript files exist:**
   ```bash
   # Should show both .sh and .ts files
   ls .claude/hooks/skill-activation-prompt.*
   # Expected:
   # skill-activation-prompt.sh
   # skill-activation-prompt.ts
   ```

3. **Test npx tsx availability:**
   ```bash
   # Try running TypeScript directly
   npx tsx .claude/hooks/skill-activation-prompt.ts --version
   ```

4. **Check hook configuration in Claude Code settings:**
   - Hooks should be enabled in `.claude/settings.json`
   - UserPromptSubmit hook should reference `skill-activation-prompt.sh`

---

## Hook Problems

### Problem: "skill-activation-prompt.js not found"

**Symptoms:**
- Error: "No such file or directory: skill-activation-prompt.js"

**Cause:**
- Incorrect file extension (should be .ts, not .js)

**Solution:**
```bash
# Verify correct files exist
ls .claude/hooks/skill-activation-prompt.*

# Should show:
# skill-activation-prompt.sh   ← Shell wrapper
# skill-activation-prompt.ts   ← TypeScript implementation

# NOT skill-activation-prompt.js
```

**If files are missing:**
```bash
# Copy from showcase repository
cp .claude/hooks/skill-activation-prompt.sh /path/to/project/.claude/hooks/
cp .claude/hooks/skill-activation-prompt.ts /path/to/project/.claude/hooks/
chmod +x .claude/hooks/skill-activation-prompt.sh
```

---

### Problem: Hooks execute but don't activate skills

**Symptoms:**
- Hooks run without errors
- But skills don't appear to be active
- No Magento 2 patterns suggested

**Diagnosis:**
```bash
# Check skill-rules.json exists
cat .claude/skill-rules.json

# Verify magento2-dev-guidelines is in skill-rules.json
grep "magento2-dev-guidelines" .claude/skill-rules.json
```

**Solutions:**

1. **Create or update skill-rules.json:**
   ```json
   {
     "skills": [
       {
         "name": "magento2-dev-guidelines",
         "triggers": {
           "keywords": ["magento", "magento2", "module", "plugin", "observer"],
           "file_patterns": ["app/code/**/*.php", "**/*.xml"],
           "intent_patterns": [
             "create.*module",
             "magento.*plugin",
             "dependency injection"
           ]
         }
       },
       {
         "name": "tdd-workflow",
         "triggers": {
           "keywords": ["test", "tdd", "phpunit"],
           "intent_patterns": ["write.*test.*first", "going afk"]
         }
       }
     ]
   }
   ```

2. **Restart Claude Code after updating skill-rules.json**

---

## Command Issues

### Problem: /m2-module command not working

**Symptoms:**
- `/m2-module Vendor_ModuleName` shows "command not found"
- No module files created

**Diagnosis:**
```bash
# Check command file exists
ls -la .claude/commands/m2-module.md

# Check it has YAML frontmatter
head -5 .claude/commands/m2-module.md
```

**Solutions:**

1. **Verify command file exists and has correct format:**
   ```bash
   # Should start with YAML frontmatter
   head -5 .claude/commands/m2-module.md
   # Expected:
   # ---
   # description: Create Magento 2 module structure with proper conventions
   # argument-hint: "<Vendor_ModuleName> <brief-description>"
   # ---
   ```

2. **Copy command if missing:**
   ```bash
   cp /path/to/showcase/.claude/commands/m2-module.md .claude/commands/
   ```

3. **Restart Claude Code**

---

### Problem: /feature command creates wrong structure

**Symptoms:**
- `documentation/features/` directory not created
- Files created in wrong location

**Diagnosis:**
```bash
# Check if running from project root
pwd

# Check if documentation/ directory exists
ls -la documentation/
```

**Solutions:**

1. **Create documentation directories:**
   ```bash
   mkdir -p documentation/modules
   mkdir -p documentation/features
   ```

2. **Run from project root:**
   ```bash
   # Make sure you're in project root, not subdirectory
   cd /path/to/project/root
   /feature feature-name "description"
   ```

---

## Skill Activation Problems

### Problem: magento2-dev-guidelines skill not activating

**Symptoms:**
- No Magento 2 patterns suggested
- DI, plugins, observers not mentioned
- Generic PHP advice instead of Magento 2 specific

**Diagnosis:**
```bash
# Check skill exists
ls -la .claude/skills/magento2-dev-guidelines/SKILL.md

# Check content
head -20 .claude/skills/magento2-dev-guidelines/SKILL.md
```

**Solutions:**

1. **Manually activate skill:**
   - In Claude Code, type: "Use the magento2-dev-guidelines skill"
   - Or mention "Magento 2" explicitly in your prompt

2. **Verify skill-rules.json has Magento 2 triggers:**
   ```json
   {
     "skills": [
       {
         "name": "magento2-dev-guidelines",
         "triggers": {
           "keywords": [
             "magento",
             "magento 2",
             "magento2",
             "m2",
             "module",
             "plugin",
             "observer",
             "di.xml",
             "preference",
             "repository pattern"
           ],
           "file_patterns": [
             "app/code/**/*.php",
             "**/etc/di.xml",
             "**/etc/module.xml",
             "**/registration.php"
           ]
         }
       }
     ]
   }
   ```

3. **Use explicit trigger words:**
   - Say "Create a Magento 2 module"
   - Instead of just "Create a module"

---

## Magento 2 Specific Issues

### Problem: Module not showing in Magento after creation

**Symptoms:**
- `/m2-module` ran successfully
- Files created in app/code/
- But `bin/magento module:status` doesn't show it

**Diagnosis:**
```bash
# Check module files exist
ls app/code/Vendor/ModuleName/

# Check registration.php
cat app/code/Vendor/ModuleName/registration.php

# Check module.xml
cat app/code/Vendor/ModuleName/etc/module.xml
```

**Solutions:**

1. **Verify registration.php is correct:**
   ```php
   <?php
   use Magento\Framework\Component\ComponentRegistrar;

   ComponentRegistrar::register(
       ComponentRegistrar::MODULE,
       'Vendor_ModuleName',  // Must match exactly
       __DIR__
   );
   ```

2. **Clear Magento cache and regenerate:**
   ```bash
   rm -rf generated/code/* generated/metadata/*
   php bin/magento setup:upgrade
   php bin/magento module:status Vendor_ModuleName
   ```

3. **Check composer autoload:**
   ```bash
   composer dump-autoload
   ```

---

### Problem: Dependency injection not working

**Symptoms:**
- Classes not injected
- "Class not found" errors
- Constructor injection fails

**Diagnosis:**
```bash
# Check di.xml exists
cat app/code/Vendor/ModuleName/etc/di.xml

# Check class exists
ls app/code/Vendor/ModuleName/Model/YourClass.php
```

**Solutions:**

1. **Verify di.xml has correct namespace:**
   ```xml
   <?xml version="1.0"?>
   <config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
           xsi:noNamespaceSchemaLocation="urn:magento:framework:ObjectManager/etc/config.xsd">
       <preference for="Vendor\ModuleName\Api\Data\EntityInterface"
                   type="Vendor\ModuleName\Model\Entity"/>
   </config>
   ```

2. **Compile and clear:**
   ```bash
   rm -rf generated/code/*
   php bin/magento setup:di:compile
   php bin/magento cache:flush
   ```

3. **Check namespace in PHP files:**
   ```php
   namespace Vendor\ModuleName\Model;  // Must match directory structure
   ```

---

### Problem: Plugin not intercepting calls

**Symptoms:**
- Plugin created via workflow
- But methods not being called
- Original method executes without plugin

**Diagnosis:**
```bash
# Check plugin configured in di.xml
grep -A 5 "<type name=" app/code/Vendor/ModuleName/etc/di.xml

# Check plugin class exists
ls app/code/Vendor/ModuleName/Plugin/
```

**Solutions:**

1. **Verify di.xml plugin configuration:**
   ```xml
   <type name="Magento\Catalog\Model\Product">
       <plugin name="vendor_module_product_plugin"
               type="Vendor\ModuleName\Plugin\ProductPlugin"
               sortOrder="10"/>
   </type>
   ```

2. **Check plugin method signatures:**
   ```php
   // For before plugins
   public function beforeMethod($subject, $arg1, $arg2) { }

   // For after plugins
   public function afterMethod($subject, $result) { }

   // For around plugins
   public function aroundMethod($subject, $proceed, $arg1) { }
   ```

3. **Clear and compile:**
   ```bash
   php bin/magento setup:di:compile
   php bin/magento cache:flush
   ```

---

## Workflow Execution Problems

### Problem: TDD workflow - tests not running

**Symptoms:**
- Said "I'm going AFK, implement"
- But Claude doesn't run tests
- No test output shown

**Diagnosis:**
```bash
# Check PHPUnit is available
vendor/bin/phpunit --version

# Check test files exist
ls -la app/code/Vendor/ModuleName/Test/Unit/
```

**Solutions:**

1. **Install PHPUnit if missing:**
   ```bash
   composer require --dev phpunit/phpunit
   ```

2. **Verify phpunit.xml exists:**
   ```bash
   # For Magento 2
   ls dev/tests/unit/phpunit.xml.dist
   ```

3. **Explicitly mention test path:**
   - Say: "Run PHPUnit tests in app/code/Vendor/ModuleName/Test/Unit/"

4. **Use tdd-workflow skill:**
   - Say: "Use TDD workflow with the tests I created"

---

### Problem: Documentation-Driven workflow - wrong phase executed

**Symptoms:**
- `/phase-exec feature-name 2` runs Phase 1 instead
- Claude loads wrong phase documentation

**Diagnosis:**
```bash
# Check plan.md exists
cat documentation/features/feature-name/plan.md

# Check design.md has phase sections
grep "^## Phase" documentation/features/feature-name/design.md
```

**Solutions:**

1. **Verify plan.md has phase structure:**
   ```markdown
   # Implementation Plan: Feature Name

   ## Phases

   - [ ] Phase 1: Database Schema
   - [ ] Phase 2: API Layer
   - [ ] Phase 3: Business Logic
   ```

2. **Verify design.md has numbered phase sections:**
   ```markdown
   ## Phase 1: Database Schema

   ...

   ## Phase 2: API Layer

   ...
   ```

3. **Use correct command syntax:**
   ```bash
   /phase-exec feature-name 2  # Space between name and number
   ```

---

### Problem: Token limit exceeded mid-workflow

**Symptoms:**
- Long conversation
- Claude says "token limit reached"
- Workflow interrupted

**Solutions:**

1. **Use Documentation-Driven workflow for fresh contexts:**
   ```bash
   # Instead of long conversation:
   /feature feature-name "description"
   /phase-exec feature-name 1
   # New thread for phase 2:
   /phase-exec feature-name 2
   ```

2. **Commit and start fresh:**
   ```bash
   git add .
   git commit -m "Phase 1 complete"
   # Start new Claude Code session
   /phase-exec feature-name 2
   ```

3. **Use TDD for focused implementation:**
   - Write tests (small context)
   - Say "I'm AFK" (Claude implements)
   - Autonomous execution (no back-and-forth)

---

## Performance and Token Issues

### Problem: Workflow consuming too many tokens

**Symptoms:**
- Hitting token limits frequently
- Claude loads entire codebase
- Slow responses

**Solutions:**

1. **Use phase isolation (Documentation-Driven):**
   - Each phase = fresh context
   - 50-70% token savings
   - Only loads current phase docs

2. **Be specific in prompts:**
   ```
   # ❌ Vague (loads everything)
   "Update the product module"

   # ✅ Specific (minimal context)
   "Update ProductRepository.php to add getByCustomerId method"
   ```

3. **Use .claudeignore:**
   ```
   # Create .claudeignore
   vendor/
   generated/
   pub/static/
   var/
   node_modules/
   ```

4. **Clear context between phases:**
   - Commit code
   - Exit Claude Code
   - Start fresh for next phase

---

### Problem: Agent taking too long to respond

**Symptoms:**
- phase-executor or tdd-driver seems stuck
- No output for several minutes

**Diagnosis:**
- Agents may be analyzing large codebase
- Or running comprehensive tests

**Solutions:**

1. **Be patient** - complex analysis takes time

2. **Reduce scope:**
   ```
   # Instead of:
   /phase-exec large-feature 1

   # Break down:
   /phase-exec large-feature-part1 1
   ```

3. **Use specific file paths:**
   - Mention exact files to modify
   - Reduces search space

---

## Common Error Messages

### "Skill not found: magento2-dev-guidelines"

**Cause:** Skill file missing or not in correct location

**Fix:**
```bash
# Check location
ls .claude/skills/magento2-dev-guidelines/SKILL.md

# Copy if missing
cp -r /path/to/showcase/.claude/skills/magento2-dev-guidelines .claude/skills/
```

---

### "Command '/m2-module' not recognized"

**Cause:** Command file missing or no YAML frontmatter

**Fix:**
```bash
# Check file
head -5 .claude/commands/m2-module.md

# Should start with ---
# Copy if needed
cp /path/to/showcase/.claude/commands/m2-module.md .claude/commands/
```

---

### "npx: command not found" (in hook output)

**Cause:** Node.js not installed or not in PATH

**Fix:**
```bash
# Install Node.js
# Ubuntu/Debian:
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Verify:
node --version
npx --version
```

---

### "Module 'Vendor_ModuleName' is not enabled"

**Cause:** Module created but not enabled in Magento

**Fix:**
```bash
php bin/magento module:enable Vendor_ModuleName
php bin/magento setup:upgrade
php bin/magento cache:flush
```

---

### "Class 'Vendor\ModuleName\Model\Class' not found"

**Cause:** DI not compiled or autoload not updated

**Fix:**
```bash
rm -rf generated/code/*
php bin/magento setup:di:compile
composer dump-autoload
```

---

## Getting Help

### Run Verification Script

```bash
.claude/verify-setup.sh
```

This will check:
- ✅ All skills, commands, agents present
- ✅ Node.js installed
- ✅ Hooks configured correctly
- ✅ Magento 2 environment (if applicable)

### Check Documentation

1. **Workflow Guide:** `.claude/dev-docs/magento2-workflow-guide.md`
2. **Best Practices:** `.claude/dev-docs/workflow-best-practices.md`
3. **Reddit Analysis:** `.claude/dev-docs/reddit-workflows-analysis.md`

### Enable Debug Output

In Claude Code session:
```
"Enable verbose logging for next command"
/m2-module Acme_Test "test"
```

### Report Issues

If issues persist:
1. Run `.claude/verify-setup.sh` and save output
2. Check `.claude/dev-docs/TROUBLESHOOTING.md` (this file)
3. Include error messages and steps to reproduce

---

## Quick Reference

### Verification Checklist

```bash
# 1. Check structure
ls .claude/{skills,agents,commands,hooks,dev-docs}

# 2. Check Node.js
node --version  # Should be v16+
npx --version

# 3. Make hooks executable
chmod +x .claude/hooks/*.sh

# 4. Verify skills
ls .claude/skills/magento2-dev-guidelines/SKILL.md

# 5. Test command
# In Claude Code:
# /m2-module Test_Module "test"

# 6. For Magento 2
ls app/code/  # Should exist
php bin/magento --version
```

### Common Commands

```bash
# Setup
.claude/verify-setup.sh

# Magento 2
/m2-module Vendor_ModuleName "description"
php bin/magento module:enable Vendor_ModuleName
php bin/magento setup:upgrade

# TDD Workflow
# 1. Write tests
# 2. Say: "I'm going AFK, implement until tests pass"

# Documentation-Driven Workflow
/feature feature-name "description"
/clarify feature-name
/research feature-name
/phase-exec feature-name 1
```

---

**Still having issues? Run `.claude/verify-setup.sh` first!**

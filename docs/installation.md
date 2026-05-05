# Installation Guide

**HK2 AddBootstrap5 for Magento 2** — `hk2/addbootstrap5 v3.0.0`

---

## Table of Contents

- [Prerequisites](#prerequisites)
- [Required Dependency](#required-dependency)
- [Method 1: Composer Installation (Recommended)](#method-1-composer-installation-recommended)
- [Method 2: Manual Installation](#method-2-manual-installation)
- [Enable the Module](#enable-the-module)
- [Production Mode Deployment](#production-mode-deployment)
- [Verify the Installation](#verify-the-installation)
- [Troubleshooting](#troubleshooting)
- [Uninstallation](#uninstallation)

---

## Prerequisites

Before installing, confirm your environment meets the following requirements:

| Requirement | Minimum Version |
| ----------- | --------------- |
| Magento     | 2.4.4           |
| PHP         | 8.2             |
| Composer    | 2.x             |
| HK2 Core    | 1.0.0           |

- SSH / CLI access to the Magento root directory
- Magento filesystem write permissions

> ⚠ **Magento 2.3.x is end-of-life and not supported.** PHP 7.x is not supported.

---

## Required Dependency

This module requires **HK2 Core** (`hk2/core`) to be installed first.

- Composer package: `hk2/core`
- Module namespace: `HK2_Core`
- Required for both Composer and manual installation methods

When using Composer, HK2 Core is automatically pulled in as a dependency.

---

## Method 1: Composer Installation (Recommended)

This is the recommended installation method. Composer will automatically resolve and install **HK2 Core** as a dependency.

**Step 1 — Require the package:**

```bash
composer require hk2/addbootstrap5
```

**Step 2 — Enable and upgrade:**

```bash
php bin/magento module:enable HK2_Core HK2_AddBootstrap5
php bin/magento setup:upgrade
php bin/magento cache:flush
```

> Proceed to [Verify the Installation](#verify-the-installation) after these steps.

---

## Method 2: Manual Installation

Use this method only when Composer is unavailable or restricted.

### Step 1 — Install HK2 Core

> **HK2 Core Module** - [https://github.com/basantmandal/magento2-hk2-core-module/archive/refs/tags/1.0.0.zip](https://github.com/basantmandal/magento2-hk2-core-module/archive/refs/tags/1.0.0.zip)

Ensure the HK2 Core module is present at:

```
app/code/HK2/Core/
```

If not already installed, copy the HK2 Core module files into that directory.

---

### Step 2 — Install HK2 AddBootstrap5

Create the module directory:

```
app/code/HK2/AddBootstrap5/
```

Copy all files from this repository into that directory, preserving the directory structure exactly.

---

### Step 3 — Enable & Activate

Run the following commands from the Magento root:

```bash
php bin/magento module:enable HK2_Core HK2_AddBootstrap5
php bin/magento setup:upgrade
php bin/magento cache:flush
```

---

## Enable the Module

After either installation method, confirm both modules are enabled:

```bash
php bin/magento module:status HK2_Core HK2_AddBootstrap5
```

Expected output:

```
HK2_Core                : enabled
HK2_AddBootstrap5       : enabled
```

---

## Production Mode Deployment

If your store operates in **production mode**, run the following additional commands after enabling the module:

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
php bin/magento cache:flush
```

> ⚠ Always run `setup:di:compile` before deploying static content in production to avoid `Class not found` errors.

---

## Verify the Installation

**Admin Panel Verification:**

1. Log in to the Magento Admin Panel.
2. Navigate to: **Stores → Configuration → HK2 → AddBootstrap5**
3. Confirm the configuration panel is visible and accessible.
4. Enable the extension and select a Bootstrap version.
5. Save and flush the cache.

**Frontend Verification (Demo Pages):**

Visit the demo routes in your browser:

```
# Bootstrap 5 Demo
https://yourstore.com/bootstrap5demo/demo/index/version/5

# Bootstrap 4 Demo
https://yourstore.com/bootstrap5demo/demo/index/version/4
```

Open the browser developer tools → Network tab and verify Bootstrap CSS and JS are loading from your selected CDN.

---

## Troubleshooting

### Extension not visible in Admin

```bash
php bin/magento module:status HK2_AddBootstrap5
php bin/magento cache:flush
```

Ensure both `HK2_Core` and `HK2_AddBootstrap5` show as `enabled`.

---

### Bootstrap assets not loading on the frontend

1. Check that the extension is enabled in Admin → Stores → Configuration → HK2 → AddBootstrap5.
2. Flush the Magento cache:

   ```bash
   php bin/magento cache:flush
   ```

3. Open browser developer tools → Console for JavaScript errors.
4. Check `var/log/system.log` for PHP-side errors.
5. Confirm your server/firewall allows outbound requests to the CDN host.

---

### CSP blocking Bootstrap assets

If Bootstrap assets are blocked by Content Security Policy:

1. Verify `etc/csp_whitelist.xml` is present in the module.
2. Flush full page cache and Magento cache:

   ```bash
   php bin/magento cache:flush
   ```

3. If using a custom CDN not listed in `csp_whitelist.xml`, add the host manually:

   ```xml
   <value id="custom_cdn" type="host">your-cdn.example.com</value>
   ```

---

### Class not found / Compilation errors

```bash
php bin/magento setup:di:compile
php bin/magento cache:flush
```

---

## Uninstallation

### Via Composer

```bash
composer remove hk2/addbootstrap5
php bin/magento setup:upgrade
php bin/magento cache:flush
```

### Manual Removal

**Step 1 — Disable the module:**

```bash
php bin/magento module:disable HK2_AddBootstrap5
```

**Step 2 — Remove the module directory:**

```
app/code/HK2/AddBootstrap5/
```

**Step 3 — Clean up:**

```bash
php bin/magento setup:upgrade
php bin/magento cache:flush
```

---

## Related

- [Compatibility Guide](./compatibility.md)
- [Usage Guide](./usage.md)
- [CHANGELOG](../CHANGELOG.md)

---

<div align="center">
  <b>Basant Mandal</b><br>
  <a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
  <a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>
  <a href="mailto:support@basantmandal.in"><img src="https://img.shields.io/badge/Email-support%40basantmandal.in-blue?style=flat-square&logo=gmail" alt="Email"></a>
  
  ---
</div>

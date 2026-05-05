# Usage Guide

**HK2 AddBootstrap5 for Magento 2** — `hk2/addbootstrap5 v3.0.0`

---

## Table of Contents

- [Admin Configuration](#admin-configuration)
- [Configuration Options Reference](#configuration-options-reference)
- [Default Values](#default-values)
- [Enabling Bootstrap on the Storefront](#enabling-bootstrap-on-the-storefront)
- [Switching Bootstrap Versions](#switching-bootstrap-versions)
- [CDN Provider Selection](#cdn-provider-selection)
- [Debug Mode](#debug-mode)
- [Demo Pages](#demo-pages)
- [Using Bootstrap in CMS Pages & Blocks](#using-bootstrap-in-cms-pages--blocks)
- [Using Bootstrap in Custom Themes](#using-bootstrap-in-custom-themes)
- [Frontend Asset Injection Details](#frontend-asset-injection-details)
- [Best Practices](#best-practices)

---

## Admin Configuration

All extension settings are managed from the Magento Admin Panel.

**Navigation path:**

```
Stores → Configuration → HK2 → AddBootstrap5
```

No code changes or file edits are required. All options are applied at runtime based on the saved configuration.

---

## Configuration Options Reference

| Option                | Description                                            | Values                           |
| --------------------- | ------------------------------------------------------ | -------------------------------- |
| **Enable Extension**  | Master switch to enable or disable Bootstrap injection | `Yes` / `No`                     |
| **Bootstrap Version** | Which Bootstrap version to load from CDN               | `4.x`, `5.2.3`, `5.3.3`, `5.3.8` |
| **CDN Provider**      | Which CDN provider serves the Bootstrap assets         | `jsDelivr`, `cdnjs`, `unpkg`     |
| **Debug Mode**        | Output diagnostic information to the browser console   | `Yes` / `No`                     |

---

## Default Values

The module ships with the following defaults (defined in `etc/config.xml`):

| Setting           | Default Value |
| ----------------- | ------------- |
| Enable Extension  | `Yes`         |
| Bootstrap Version | `5.3.8`       |
| CDN Provider      | `jsDelivr`    |
| Debug Mode        | `No`          |

These defaults apply on first installation before any Admin configuration is saved.

---

## Enabling Bootstrap on the Storefront

1. Log in to the Magento Admin Panel.
2. Navigate to **Stores → Configuration → HK2 → AddBootstrap5**.
3. Set **Enable Extension** to `Yes`.
4. Select your preferred **Bootstrap Version**.
5. Select your preferred **CDN Provider**.
6. Click **Save Config**.
7. Flush the cache when prompted, or run:

```bash
php bin/magento cache:flush
```

Bootstrap CSS and JS will now be injected on every storefront page.

---

## Switching Bootstrap Versions

To change the Bootstrap version:

1. Navigate to **Stores → Configuration → HK2 → AddBootstrap5**.
2. Change the **Bootstrap Version** dropdown to your desired version.
3. Click **Save Config**.
4. Flush the cache.

> No static content redeployment is required — CDN URLs are resolved at runtime.

---

## CDN Provider Selection

The module supports three CDN providers. All are pre-whitelisted in the CSP configuration.

| CDN Provider           | Host                   | Notes                            |
| ---------------------- | ---------------------- | -------------------------------- |
| **jsDelivr** (Default) | `cdn.jsdelivr.net`     | High availability, global CDN    |
| **cdnjs**              | `cdnjs.cloudflare.com` | Cloudflare-backed, fast globally |
| **unpkg**              | `unpkg.com`            | npm-sourced assets               |

Select the CDN closest to your user base or that fits your infrastructure requirements.

---

## Debug Mode

When **Debug Mode** is enabled, the module outputs non-intrusive diagnostic information to the browser console. This is useful for:

- Verifying which Bootstrap version is active
- Confirming assets are injected correctly
- Debugging CDN connectivity issues

> ⚠ **Recommended for development environments only.** Disable Debug Mode before going live in production.

To enable:

1. Navigate to **Stores → Configuration → HK2 → AddBootstrap5**.
2. Set **Debug Mode** to `Yes`.
3. Save and flush cache.
4. Open the browser developer tools → Console tab.

---

## Demo Pages

The module includes frontend demo pages to verify Bootstrap is loaded and functional.

### Bootstrap 5 Demo

```
https://yourstore.com/bootstrap5demo/demo/index/version/5
```

### Bootstrap 4 Demo

```
https://yourstore.com/bootstrap5demo/demo/index/version/4
```

The demo pages render standard Bootstrap UI components (buttons, cards, alerts, grids) to visually confirm integration.

> Demo pages are visible to frontend visitors by default. Consider restricting access in production using Magento ACL or server-level rules.

---

## Using Bootstrap in CMS Pages & Blocks

Once Bootstrap is enabled, you can use Bootstrap HTML markup directly in Magento CMS Pages and Static Blocks.

### Example — Bootstrap Alert in a CMS Block

```html
<div class="alert alert-success" role="alert">
  This is a Bootstrap success alert.
</div>
```

### Example — Bootstrap Grid in a CMS Page

```html
<div class="container">
  <div class="row">
    <div class="col-md-6">
      <h2>Column 1</h2>
      <p>Your content here.</p>
    </div>
    <div class="col-md-6">
      <h2>Column 2</h2>
      <p>Your content here.</p>
    </div>
  </div>
</div>
```

### Example — Bootstrap Card Component

```html
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Card Title</h5>
    <p class="card-text">Some quick example text.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>
```

> Bootstrap JavaScript components (modals, dropdowns, carousels) require proper Bootstrap markup and will function automatically once the JS bundle is loaded.

---

## Using Bootstrap in Custom Themes

Since Bootstrap is injected via Magento's PageConfig system, it is available globally across all frontend pages. You can reference Bootstrap classes in any template file (`.phtml`) or layout XML.

### In a `.phtml` Template

```php
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="card-title"><?= $block->escapeHtml($block->getTitle()) ?></h1>
                </div>
            </div>
        </div>
    </div>
</div>
```

### Avoiding Theme CSS Conflicts

If Bootstrap classes conflict with existing Magento Luma or custom theme styles:

- Use Bootstrap's utility classes selectively.
- Scope Bootstrap to specific page handles via layout XML if needed.
- Override conflicting Bootstrap variables in a theme LESS/CSS file.

---

## Frontend Asset Injection Details

When enabled, the extension registers the following assets on every storefront page using Magento's PageConfig API:

| Asset Type          | Source           | Method                  |
| ------------------- | ---------------- | ----------------------- |
| Bootstrap CSS       | Selected CDN     | `<head>` via PageConfig |
| Bootstrap JS Bundle | Selected CDN     | `<head>` via PageConfig |
| Debug JS (optional) | RequireJS module | Conditional             |

All assets are loaded from trusted, pre-whitelisted CDN hosts. No inline scripts or styles are used.

---

## Best Practices

- ✅ **Enable Bootstrap only if needed** — avoid loading it if your theme already includes Bootstrap.
- ✅ **Disable Debug Mode in production** — browser console output is unnecessary overhead for end users.
- ✅ **Test after CDN changes** — verify Bootstrap loads after switching CDN providers.
- ✅ **Use semantic Bootstrap markup** — ensures compatibility across Bootstrap 4 and 5.
- ✅ **Flush cache after configuration changes** — configuration is cached; always flush after updates.
- ⚠ **Avoid loading both Bootstrap 4 and 5 simultaneously** — use the version selector to choose one.
- ⚠ **Test JavaScript components thoroughly** — Bootstrap JS requires correct data attributes and DOM structure to function.

---

## Related

- [Installation Guide](./installation.md)
- [Compatibility Guide](./compatibility.md)
- [CHANGELOG](../CHANGELOG.md)

---

<div align="center">
  <b>Basant Mandal</b><br>
  <a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
  <a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>
  <a href="mailto:support@basantmandal.in"><img src="https://img.shields.io/badge/Email-support%40basantmandal.in-blue?style=flat-square&logo=gmail" alt="Email"></a>
  
  ---
</div>

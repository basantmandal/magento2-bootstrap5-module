# Usage Guide

## Getting Started

HK2_AddBootstrap5 is designed to work immediately after installation with sensible defaults. The module is enabled by default and loads Bootstrap 5.3.8 from the jsDelivr CDN on all frontend pages.

---

## Admin Panel

### Navigating to configuration

1. Log in to the Magento admin panel.
2. Go to **Stores > Settings > Configuration**.
3. In the left panel under the **HK2** tab, click **Add Bootstrap5**.

Alternatively, use the menu: **System > HK2 > Add Bootstrap 5**.

### Configuration fields

#### Enable Extension

Toggle Bootstrap loading on or off for the entire storefront. When set to **No**, no Bootstrap CSS or JavaScript is loaded, and the `BootstrapAssets` block returns early without adding any assets.

**Default:** Yes

#### Select Bootstrap Version

Choose the Bootstrap version to load. The dropdown includes:

| Option | Details |
|---|---|
| Bootstrap 4.4.1 | Bootstrap 4.4.1 |
| Bootstrap 4.5.3 | Bootstrap 4.5.3 |
| Bootstrap 4.6.2 | Bootstrap 4.6.2 (latest Bootstrap 4 release) |
| Bootstrap 5.0.2 | Bootstrap 5.0.2 (initial stable 5.x release) |
| Bootstrap 5.1.3 | Bootstrap 5.1.3 |
| Bootstrap 5.2.3 | Bootstrap 5.2.3 |
| Bootstrap 5.3.8 (Latest) | Bootstrap 5.3.8 (default -- latest stable 5.x release) |

Switching the version takes immediate effect after saving the configuration and clearing the cache.

**Important:** Bootstrap 4 and 5 have different markup requirements. Switching from version 5 to version 4 may break components that use Bootstrap 5-specific HTML attributes (e.g., `data-bs-*` instead of `data-*`). The demo page automatically detects the version and renders appropriate markup for each.

**Default:** 5.3.8

#### Select CDN Provider

Currently provides a single option -- **jsDelivr CDN**. The CSP whitelist already includes `cdnjs.cloudflare.com` and `unpkg.com` for future expansion when additional CDN providers are implemented.

**Default:** jsDelivr CDN

#### Enable Debug Mode

When set to **Yes**, the `bootstrap-debug.js` RequireJS module is initialized on every page via `x-magento-init`. Open the browser console to see:

```
HK2 AddBootstrap5 Module
  Bootstrap Version: 5.3.8
  CDN Provider: jsdelivr
```

This is useful for verifying which version and CDN are active after configuration changes.

**Default:** No

---

## How Bootstrap Is Loaded

### CSS

Bootstrap's `bootstrap.min.css` is loaded via `Magento\Framework\View\Page\Config::addRemotePageAsset()` as a `css` asset type. This adds a `<link rel="stylesheet">` element in the `<head>` section of every frontend page.

URL pattern:
```
https://cdn.jsdelivr.net/npm/bootstrap@{version}/dist/css/bootstrap.min.css
```

### JavaScript

Bootstrap's `bootstrap.bundle.min.js` (which includes Popper.js) is loaded asynchronously after the `window.load` event using a dynamically created `<script>` element. The JavaScript is **not** loaded via RequireJS -- instead, the template temporarily sets `window.define.amd = false` before appending the script tag, which prevents RequireJS from intercepting Bootstrap's AMD-compatible UMD wrapper. After the script loads, the original `define.amd` value is restored.

URL pattern:
```
https://cdn.jsdelivr.net/npm/bootstrap@{version}/dist/js/bootstrap.bundle.min.js
```

This approach ensures:
- Bootstrap JavaScript does not block page rendering (async after `window.load`).
- Bootstrap does not interfere with Magento's RequireJS AMD loader.
- jQuery-based Bootstrap 4 components work correctly (Magento 2 ships with jQuery).

---

## Demo Page

The module includes a built-in demo page that showcases Bootstrap components. This is useful for:

- Quickly verifying that Bootstrap is loading correctly after configuration changes.
- Comparing Bootstrap 4 vs. Bootstrap 5 markup differences.
- Testing CDN connectivity and CSP compliance.
- Demonstrating the module to stakeholders.

### Accessing the demo

| Version | URL |
|---|---|
| Bootstrap 5 (default) | `http://your-store.com/addbootstrap5/demo` |
| Bootstrap 4 | `http://your-store.com/addbootstrap5/demo?version=4` |

### Demo components

The demo page renders the following Bootstrap components:

- **Alerts** -- primary, success, and danger variants
- **Table** -- striped table with sample data
- **Accordion** -- Bootstrap 5 uses the `accordion` component with `data-bs-*` attributes; Bootstrap 4 uses cards with `data-*` attributes
- **Buttons** -- all color variants (primary, secondary, success, danger, warning, info, light, dark)
- **Grid** -- 3-column responsive grid using `col-md-4`
- **Cards** -- two card layouts (featured header, basic body)
- **Form elements** -- email input, password input, select dropdown, checkbox, submit button
- **Verification alert** -- confirmation message at the bottom indicating successful Bootstrap loading

### Version detection

The demo controller (`HK2\AddBootstrap5\Controller\Demo\Index`) reads the `version` query parameter and passes it to the demo block, which returns it to the template. The template uses `((int)$version >= 5)` to conditionally render Bootstrap 5 or Bootstrap 4 markup. This ensures the demo always uses the correct HTML attributes for the selected version.

---

## Workflow Example

### Standard setup

1. **Install** the module via Composer and Magento CLI commands.
2. **Verify** the module is enabled (default) and Bootstrap 5.3.8 is selected.
3. **Visit** any storefront page -- Bootstrap CSS loads in `<head>`.
4. **Use** Bootstrap classes in your CMS blocks, product descriptions, or custom templates.

### Switching to Bootstrap 4

1. Navigate to **Stores > Configuration > HK2 > Add Bootstrap5**.
2. Change **Select Bootstrap Version** to **Bootstrap 4.6.2**.
3. Click **Save Config**.
4. Run `bin/magento cache:flush`.
5. Visit `/addbootstrap5/demo?version=4` to verify the correct version is loading.

### Troubleshooting with debug mode

1. Enable **Debug Mode** in the admin configuration.
2. Save and clear cache.
3. Open the browser console on any frontend page.
4. Confirm the logged version and CDN match your configuration.

---

## Frontend Behavior

### Bootstrap CSS

Once the module is enabled, `bootstrap.min.css` is loaded in the `<head>` of every frontend page via a `<link>` tag. The URL always points to jsDelivr CDN at the configured version.

### Bootstrap JavaScript

The JavaScript bundle is loaded asynchronously after `window.load` to avoid blocking page rendering. The inline script in `include.phtml` handles the AMD conflict by temporarily disabling RequireJS's AMD detection during script load.

### Debug output

When debug mode is enabled, a console group named **HK2 AddBootstrap5 Module** displays the active version and CDN provider on every page load.

---

## Custom Code Integration

### Using Bootstrap in CMS content

Once the module is enabled, you can use any Bootstrap CSS class directly in CMS pages, blocks, and widget content:

```html
<div class="container mt-4">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Custom Content</h5>
          <p class="card-text">Bootstrap-styled content in a CMS block.</p>
        </div>
      </div>
    </div>
  </div>
</div>
```

### Using Bootstrap in custom templates

Bootstrap classes work in any `.phtml` template. The module loads Bootstrap globally, so no additional setup is needed:

```php
// In any frontend template
<button class="btn btn-primary">Click Me</button>
```

### Using Bootstrap JavaScript components

Bootstrap JavaScript components are available after `window.load`. Since Bootstrap JS loads asynchronously, do not reference `bootstrap` globals in inline scripts that execute before `window.load`. Use the `load` event listener or defer custom JavaScript:

```javascript
window.addEventListener('load', function () {
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));
    myModal.show();
});
```

---

## Notes

- The module injects Bootstrap into the `after.body.start` container. If your theme removes or overrides this container in `default.xml`, Bootstrap assets will not load.
- The CDN URL is constructed from the configuration value only. If you need a custom CDN URL, you can extend the `BootstrapAssets` block class via a plugin (interceptor).
- The CSP whitelist entries are merged with any existing CSP configuration. If your Magento instance already whitelists these CDN hosts, there is no conflict.

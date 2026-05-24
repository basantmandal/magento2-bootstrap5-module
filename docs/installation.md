# Installation Guide

## Prerequisites

Before installing HK2_AddBootstrap5, ensure your Magento instance meets the following requirements:

| Requirement | Minimum |
|---|---|
| Magento | 2.4.x (Open Source, Commerce, or Cloud) |
| PHP | 8.1, 8.2, 8.3, or 8.4 |
| Composer | 2.x |
| hk2/core | ^1.0 (installed automatically as a dependency) |

---

## Step 1: Install via Composer

Run the following command from your Magento root directory:

```bash
composer require hk2/addbootstrap5
```

This installs the module and its dependency `hk2/core ^1.0`.

---

## Step 2: Enable the Module

```bash
bin/magento module:enable HK2_AddBootstrap5
```

---

## Step 3: Run Setup Upgrade

```bash
bin/magento setup:upgrade
```

This registers the module in Magento's configuration, applies the default configuration values from `etc/config.xml`, and registers the CSP whitelist entries.

---

## Step 4: Compile Dependency Injection

```bash
bin/magento setup:di:compile
```

---

## Step 5: Deploy Static Content (Production Mode Only)

If your Magento instance is in **production mode**, deploy static content:

```bash
bin/magento setup:static-content:deploy
```

---

## Step 6: Clear Cache

```bash
bin/magento cache:flush
```

---

## Verification

### Verify admin configuration

1. Log in to the Magento admin panel.
2. Navigate to **Stores > Settings > Configuration > HK2 > Add Bootstrap5**.
3. Confirm the following default values are displayed:
   - **Enable Extension:** Yes
   - **Select Bootstrap Version:** 5.3.8 (Latest)
   - **Select CDN Provider:** jsDelivr CDN
   - **Enable Debug Mode:** No

### Verify Bootstrap loads on storefront

1. Open any frontend page in your browser.
2. Inspect the `<head>` section of the HTML.
3. You should see a `<link rel="stylesheet">` element pointing to:
   `https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css`
4. Inspect the bottom of the `<body>` -- after `window.load`, you should see an injected `<script>` element pointing to:
   `https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js`

### Verify the demo page

Visit `http://your-store.com/addbootstrap5/demo`. You should see a styled demo page with alerts, tables, accordions, buttons, cards, forms, and grid columns. To view the Bootstrap 4 demo, append `?version=4` to the URL.

### Verify with browser console (debug mode)

1. Go to **Stores > Settings > Configuration > HK2 > Add Bootstrap5**.
2. Set **Enable Debug Mode** to **Yes**.
3. Clear the Magento cache.
4. Open any storefront page and open the browser console.
5. You should see a console group titled **HK2 AddBootstrap5 Module** with the version and CDN provider logged.

---

## Troubleshooting

### Bootstrap does not load

| Cause | Check |
|---|---|
| Module not enabled | Verify `bin/magento module:status HK2_AddBootstrap5` shows "Enabled" |
| Extension disabled in config | Check admin config: Enable Extension must be set to Yes |
| Cache not cleared | Run `bin/magento cache:flush` |
| CSP blocking the CDN | Check browser console for CSP errors; verify `etc/csp_whitelist.xml` is deployed (`bin/magento setup:upgrade`) |
| Layout XML not applied | Verify `view/frontend/layout/default.xml` is not overridden by a custom theme |

### Demo page returns 404

| Cause | Check |
|---|---|
| Frontend route not registered | Run `bin/magento setup:upgrade` |
| Module sequence issue | Verify `HK2_Core` is enabled and `hk2/core ^1.0` is installed |

### "Bootstrap version is not configured" error

This exception is thrown by `BootstrapAssets::getCdnUrls()` when the version config value is empty. Ensure the **Select Bootstrap Version** field has a value selected in the admin configuration.

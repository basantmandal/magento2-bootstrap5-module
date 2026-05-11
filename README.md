<p align="center">
<img src="https://img.shields.io/badge/version-1.0.0-blue?style=flat-square" alt="Version">
<img src="https://img.shields.io/badge/Magento-2.4.x-f97316?style=flat-square&logo=magento&logoColor=white" alt="Magento">
<img src="https://img.shields.io/badge/PHP-8.2%2B-7c3aed?style=flat-square&logo=php&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/license-OSL--3.0-green?style=flat-square" alt="License">
<a href="https://packagist.org/packages/hk2/addbootstrap5"><img src="https://img.shields.io/packagist/dt/hk2/addbootstrap5?style=flat-square" alt="Packagist"></a>
<br>
<a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
<a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>
<a href="mailto:support@basantmandal.in"><img src="https://img.shields.io/badge/Email-support%40basantmandal.in-blue?style=flat-square&logo=gmail" alt="Email"></a>
</p>

# HK2 AddBootstrap5 -- Load Bootstrap 4/5 on Magento 2 Storefront

**HK2_AddBootstrap5** enables administrators to load Bootstrap 4 or Bootstrap 5 CSS and JavaScript on the Magento 2 storefront from the jsDelivr CDN -- without modifying theme files or creating child themes.

---

## Overview

HK2_AddBootstrap5 is a Magento 2 extension that injects Bootstrap CSS and JavaScript into the `after.body.start` container on all frontend pages. CSS is loaded synchronously via `Magento\Framework\View\Page\Config::addRemotePageAsset()`, while the JavaScript bundle is injected asynchronously after `window.load` with a RequireJS AMD conflict workaround.

The module supports seven Bootstrap versions across the 4.x and 5.x release lines, includes a debug mode for troubleshooting, and provides a built-in demo page to verify correct loading.

---

## Problem Statement

Adding Bootstrap to a Magento 2 storefront traditionally requires:

- Creating or modifying a child theme to include Bootstrap CSS/JS in `default_head_blocks.xml` or a theme `requirejs-config.js`.
- Manually managing CDN URLs and version updates across environments.
- Handling the well-known RequireJS AMD / Bootstrap jQuery conflict where Bootstrap's UMD module definition interferes with Magento's AMD loader.
- Repeating the same work for every project or when switching themes.

Without a module-based solution, store owners and developers must either hardcode CDN references into theme files or allocate development time to child theme creation and maintenance.

---

## Solution Approach

HK2_AddBootstrap5 solves these problems through a declarative, configuration-driven approach:

1. **Layout-based injection** via `default.xml` -- the BootstrapAssets block is added to the `after.body.start` container across all frontend pages, with no theme file modifications required.
2. **Admin configuration** -- Bootstrap version (4/5), CDN provider, and debug mode are managed through the Magento admin panel at Stores > Configuration > HK2 > Add Bootstrap5.
3. **Safe JS loading** -- Bootstrap's JavaScript bundle is loaded asynchronously after `window.load`, with a temporary `define.amd = false` workaround that prevents RequireJS from intercepting Bootstrap's AMD-compatible UMD wrapper. AMD mode is restored on script `onload`.
4. **CDN flexibility** -- CSS loads via `addRemotePageAsset()` for standard Magento asset management. The CDN provider model is extensible (future providers planned), and CSP whitelisting covers jsDelivr, cdnjs, and unpkg domains.

---

## Alternatives Considered

| Alternative | Limitation |
|---|---|
| Manual child theme modification | Requires developer effort per project; version updates need code changes; no admin UI |
| Composer-based Bootstrap package | Adds node_modules/build step overhead; conflicting Bootstrap versions across modules |
| Copying Bootstrap files to `pub/static` | Bypasses CDN performance benefits; manual cache management |
| Magento UI library (Less) | Bootstrap 5 dropped Less support; requires migration to SCSS; no JS components |

---

## Who is this for?

- **Magento 2 store owners** who want Bootstrap-powered frontend without hiring a developer for theme work.
- **Frontend developers** who need Bootstrap available globally on the storefront without child theme overhead.
- **Agencies** deploying Magento stores who want a repeatable, configurable Bootstrap integration across client projects.
- **Theme builders** who want to decouple Bootstrap loading from theme logic.

---

## Use Cases

| Use Case | Description |
|---|---|
| **Quick Bootstrap integration** | Enable the module in admin, select a version, and Bootstrap loads on every page. No theme files touched. |
| **Version switching** | Switch between Bootstrap 4.6.2 and 5.3.8 at any time via the admin dropdown -- instantly propagate the change across the entire storefront. |
| **Debugging CDN issues** | Enable debug mode to print the loaded Bootstrap version and CDN provider to the browser console. |
| **Demo / testing** | Visit `/addbootstrap5/demo` to verify Bootstrap is loading correctly with a showcase of alerts, cards, forms, accordions, and grid components. |

---

## Key Features

- **CDN-based loading** -- Bootstrap CSS and JS are served from the jsDelivr CDN (`cdn.jsdelivr.net`), ensuring fast, globally distributed delivery with no local asset compilation.
- **Version selection (4.x / 5.x)** -- Choose from 7 supported versions: 4.4.1, 4.5.3, 4.6.2, 5.0.2, 5.1.3, 5.2.3, 5.3.8.
- **No theme modification required** -- Assets are injected via layout XML, not theme files. Works with any Magento 2 theme out of the box.
- **Debug mode** -- When enabled, writes the active Bootstrap version and CDN provider to the browser console via `bootstrap-debug.js`.
- **Demo page** -- A built-in reference page at `/addbootstrap5/demo` demonstrates Bootstrap components (alerts, buttons, cards, forms, accordions, grid) for both v4 and v5.
- **RequireJS AMD conflict workaround** -- Bootstrap's UMD module definition is temporarily disabled during load to prevent interference with Magento's AMD loader.
- **CSP whitelisting** -- Pre-configured `csp_whitelist.xml` covers jsDelivr, cdnjs, and unpkg for both `script-src` and `style-src` policies.
- **i18n support** -- Translation files for English (`en_US`), Hindi (`hi_IN`), and Russian (`ru_RU`).

---

## Architecture Overview

```
HK2_AddBootstrap5 (this module)
│
├── Block/
│   └── Bootstrap/
│       └── BootstrapAssets.php    ← Block that adds CSS via PageConfig + renders JS template
│
├── Controller/
│   └── Demo/
│       └── Index.php              ← Frontend route /addbootstrap5/demo
│
├── Model/
│   └── Config/
│       ├── BootstrapVersion.php   ← Source model for version dropdown
│       └── CdnProvider.php        ← Source model for CDN provider dropdown
│
├── view/
│   └── frontend/
│       ├── layout/
│       │   ├── default.xml        ← Injects BootstrapAssets into after.body.start
│       │   └── addbootstrap5_demo_index.xml ← Demo page layout
│       ├── templates/
│       │   ├── bootstrap/
│       │   │   └── include.phtml  ← AMD-safe async JS loading + debug init
│       │   └── demo/
│       │       └── index.phtml    ← Demo page markup (alerts, cards, forms, etc.)
│       └── web/
│           └── js/
│               └── bootstrap-debug.js ← Console logger (version + CDN)
│
├── etc/
│   ├── module.xml                 ← Sequences on HK2_Core, Magento_Backend, Config, Store
│   ├── config.xml                 ← Default config (enabled, v5.3.8, jsDelivr)
│   ├── csp_whitelist.xml          ← CSP hosts for CDN resources
│   ├── acl.xml                    ← ACL resource for admin settings
│   ├── adminhtml/
│   │   ├── system.xml             ← Configuration fields under HK2 tab
│   │   ├── menu.xml               ← Menu item under System > HK2
│   │   └── routes.xml             ← Admin route registration
│   └── frontend/
│       └── routes.xml             ← Frontend route for demo page
│
├── i18n/
│   ├── en_US.csv
│   ├── hi_IN.csv
│   └── ru_RU.csv
│
└── registration.php               ← Magento component registration
```

### Asset Loading Flow

```
1. Request -> Magento layout loads default.xml
2. BootstrapAssets block (_prepareLayout) checks if module is enabled
3. If enabled: adds CSS via PageConfig::addRemotePageAsset()
   -> https://cdn.jsdelivr.net/npm/bootstrap@{version}/dist/css/bootstrap.min.css
4. Block renders include.phtml template in after.body.start
5. Template outputs an inline <script> that waits for window.load
6. On load: temporarily sets define.amd = false, appends JS <script> to body
   -> https://cdn.jsdelivr.net/npm/bootstrap@{version}/dist/js/bootstrap.bundle.min.js
7. On script load: restores original define.amd value
8. If debug enabled: x-magento-init loads bootstrap-debug.js -> console.log
```

---

## System Requirements

### Supported Magento Versions

- Magento **2.4.x** (Open Source / Commerce / Cloud)
- `magento/framework` **^103.0.0**

### Supported PHP Versions

| PHP Version | Compatibility |
|---|---|
| 8.1 | Fully supported |
| 8.2 | Fully supported |
| 8.3 | Fully supported |
| 8.4 | Fully supported |

### Supported Bootstrap Versions

| Bootstrap | Versions |
|---|---|
| 4.x | 4.4.1, 4.5.3, 4.6.2 |
| 5.x | 5.0.2, 5.1.3, 5.2.3, 5.3.8 |

### Platform

- Magento 2 instance (any edition) running on a standard LAMP/LEMP stack
- Composer 2.x for installation

### Dependencies

- **hk2/core** ^1.0 -- Provides the shared HK2 admin tab, menu parent, and module header block.
- **magento/framework** ^103.0.0 -- Core Magento framework.

---

## Installation

### Composer

```bash
composer require hk2/addbootstrap5
```

### Magento CLI

```bash
bin/magento module:enable HK2_AddBootstrap5
bin/magento setup:upgrade
bin/magento setup:di:compile
bin/magento cache:flush
```

### Verification

1. Log in to the Magento admin panel.
2. Navigate to **Stores > Settings > Configuration > HK2 > Add Bootstrap5**.
3. Confirm the "Enable Extension" field is set to **Yes** (default).
4. Visit any storefront page and inspect the HTML `<head>` -- you should see a `<link>` to `cdn.jsdelivr.net/npm/bootstrap@{version}/dist/css/bootstrap.min.css`.
5. Visit `/addbootstrap5/demo` -- the demo page should render with full Bootstrap styling.

See [docs/installation.md](docs/installation.md) for detailed steps and troubleshooting.

---

## Configuration

### Admin Panel Path

**Stores > Settings > Configuration > HK2 > Add Bootstrap5**

### Fields

| Field | Config Path | Type | Default | Description |
|---|---|---|---|---|
| Enable Extension | `hk2_addbootstrap5_enable` | Yes/No | Yes | Enable or disable Bootstrap loading on the storefront |
| Select Bootstrap Version | `hk2_addBootstrap5_select_bootstrap_version` | Select | 5.3.8 | Choose from 7 Bootstrap versions (4.4.1, 4.5.3, 4.6.2, 5.0.2, 5.1.3, 5.2.3, 5.3.8) |
| Select CDN Provider | `hk2_addbootstrap5_select_cdn` | Select | jsDelivr | Currently supports jsDelivr; cdnjs and unpkg are prepared for future expansion |
| Enable Debug Mode | `hk2_addbootstrap5_debug` | Yes/No | No | When enabled, logs the active Bootstrap version and CDN provider to the browser console |

### Menu Path

**System > HK2 > Add Bootstrap 5**

---

## Demo Pages

The module ships with a built-in demo page for quick verification:

| Version | URL |
|---|---|
| Bootstrap 5 (default) | `/addbootstrap5/demo` |
| Bootstrap 4 | `/addbootstrap5/demo?version=4` |

The demo page showcases:
- Alerts (primary, success, danger)
- Striped table
- Accordion component (v4 card-based, v5 accordion-based)
- Button variants (primary through dark)
- 3-column grid system
- Cards with headers and body content
- Form elements (email, password, select, checkbox)

---

## Content Security Policy (CSP)

The module ships with a pre-configured `etc/csp_whitelist.xml` that whitelists the following hosts:

| Policy | Host | Purpose |
|---|---|---|
| `script-src` | `cdn.jsdelivr.net` | Bootstrap JS bundle |
| `script-src` | `cdnjs.cloudflare.com` | Prepared for future CDN expansion |
| `script-src` | `unpkg.com` | Prepared for future CDN expansion |
| `style-src` | `cdn.jsdelivr.net` | Bootstrap CSS |
| `style-src` | `cdnjs.cloudflare.com` | Prepared for future CDN expansion |
| `style-src` | `unpkg.com` | Prepared for future CDN expansion |
| `img-src` | `www.basantmandal.in` | Author website images |

These whitelist entries are automatically applied when Magento's CSP module is enabled. No manual CSP configuration is required.

---

## Privacy & GDPR

- **No data collection** -- HK2_AddBootstrap5 does not collect, store, or transmit any personal data.
- **No cookies** -- The module sets no cookies, session data, or tracking mechanisms.
- **No third-party analytics** -- The CDN-hosted Bootstrap files are pure CSS/JS assets; they contain no tracking, analytics, or telemetry.
- **No user data processing** -- The module executes no observers, plugins, or scheduled tasks that handle customer or admin personally identifiable information (PII).
- **External CDN requests** -- When the module is enabled, the browser makes requests to `cdn.jsdelivr.net` to fetch Bootstrap files. These are standard static asset requests. The jsDelivr CDN is a public open-source CDN; see [jsDelivr privacy policy](https://www.jsdelivr.com/terms/privacy-policy) for details on their data handling.

---

## Documentation

| Document | Description |
|---|---|
| [Installation Guide](docs/installation.md) | Composer installation, Magento CLI commands, and verification |
| [Usage Guide](docs/usage.md) | Complete walkthrough of admin configuration, demo pages, and debug mode |
| [Compatibility Matrix](docs/compatibility.md) | Supported Magento, PHP, and Bootstrap versions |
| [CHANGELOG](CHANGELOG.md) | Version history and release notes |
| [SECURITY](SECURITY.md) | Vulnerability reporting and disclosure policy |

---

## Known Limitations

- **Single CDN provider** -- The CDN provider dropdown currently offers jsDelivr only. cdnjs and unpkg are whitelisted in the CSP and present in the source model structure, but the module has not yet implemented the provider selection logic to switch CDN URLs. This is planned for a future release.
- **Global scope, no per-page toggle** -- When enabled, Bootstrap loads on every frontend page. There is no per-page, per-route, or per-category toggle to selectively disable Bootstrap on specific pages.
- **No store-scope override** -- Configuration fields are scoped to Default (`showInStore="0"`, `showInWebsite="0"`). Multi-store instances cannot configure different Bootstrap versions or enable/disable the module per store view or website.
- **Bootstrap jQuery dependency** -- Bootstrap 4 relies on jQuery for its JavaScript components. Magento 2 ships with jQuery by default, so this is not a practical limitation, but store owners on Bootstrap 4 should be aware that `bootstrap.bundle.min.js` includes Popper.js but not jQuery.

---

## Contributing

Contributions are welcome! Please follow these guidelines:

1. **Bug reports** -- Open a GitHub issue with a clear description, reproduction steps, and environment details.
2. **Pull requests** -- Fork the repository, create a feature branch, and submit a PR against `main`. Ensure commits follow [Conventional Commits](https://www.conventionalcommits.org/) (`feat:`, `fix:`, `docs:`, etc.).
3. **Code style** -- Run `./vendor/bin/phpcs --standard=phpcs.xml .` before submitting. This module follows the Magento 2 coding standard with PSR12.
4. **No test infrastructure** -- This module currently has no test suite (no `phpunit.xml`, no `tests/` directory). If you add tests, please ensure they pass.

By contributing, you agree that your contributions will be licensed under the OSL-3.0 license.

---

## License

**Open Software License (OSL 3.0)**

Copyright (c) 2023-2026 Basant Mandal (Hash Tag Kitto) (HK2)

This software is licensed under the Open Software License version 3.0. A copy of the license is included in [`LICENSE.txt`](LICENSE.txt).

The AFL-3.0 license also applies as a secondary license for specific distribution channels (e.g., Magento Marketplace). For details, see the full license text.

---

## Disclaimer

This software is provided "as is", without warranty of any kind, express or implied, including but not limited to the warranties of merchantability, fitness for a particular purpose, and non-infringement. In no event shall the authors or copyright holders be liable for any claim, damages, or other liability, whether in an action of contract, tort, or otherwise, arising from, out of, or in connection with the software or the use or other dealings in the software.

The logo, branding, and trademark "HK2" and "Hash Tag Kitto" are the property of Basant Mandal. This module is not affiliated with, endorsed by, or sponsored by Adobe Inc. or any of its subsidiaries.

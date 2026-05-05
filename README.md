<div align="center">

# HK2 AddBootstrap5 Module for Magento 2

**Easily inject Bootstrap 4 or Bootstrap 5 into any Magento 2 storefront — no theme edits required.**

<img src="https://img.shields.io/badge/version-3.0.0-blue?style=flat-square" alt="Version">
<img src="https://img.shields.io/badge/Magento-2.4.x-f97316?style=flat-square&logo=magento&logoColor=white" alt="Magento">
<img src="https://img.shields.io/badge/PHP-8.2%2B-7c3aed?style=flat-square&logo=php&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/license-OSL--3.0-green?style=flat-square" alt="License">

<a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
<a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>
<a href="https://packagist.org/packages/hk2/addbootstrap5"><img src="https://img.shields.io/packagist/dt/hk2/addbootstrap5?style=flat-square" alt="Packagist"></a>

</div>

---

## 📄 Overview

**HK2 AddBootstrap5** is a lightweight, production-ready Magento 2 extension that allows administrators to load **Bootstrap 4.x or Bootstrap 5.x** on the storefront directly from the Admin Panel — without modifying theme files or creating child themes.

All assets are injected via Magento's native **PageConfig** and **layout XML** systems, making the extension upgrade-safe, CSP-compliant, and fully compatible with Magento 2.4.x.

### 👥 Who is this for?

- Developers and merchants using **Bootstrap in CMS pages or blocks**
- Teams integrating **third-party Bootstrap-based UI components**
- Agencies performing **rapid UI prototyping** without theme changes
- Stores adding **Bootstrap overlays, modals, or carousels** without a full theme rebuild

---

## 🧠 Problem Statement

Magento 2's default frontend themes (Luma, Blank) do not include Bootstrap, which is one of the most widely used CSS frameworks for building responsive, mobile-first web interfaces. Developers who need Bootstrap components face several challenges:

- **Manual integration** requires modifying theme files, which breaks on theme updates
- **Child themes** add complexity and maintenance overhead
- **Multiple CDN versions** (Bootstrap 4.x vs 5.x) require separate implementation strategies
- **Content Security Policy (CSP)** in Magento 2.4.x strict mode blocks external CDN assets without proper whitelisting

---

## 💡 Solution Approach

HK2 AddBootstrap5 solves this by:

- **Zero theme modifications** — Bootstrap is injected via Magento's PageConfig API, leaving theme files untouched
- **Admin-configurable** — Switch Bootstrap versions and CDN providers without code changes
- **CSP-compliant out of the box** — Ships with pre-configured `csp_whitelist.xml` for all supported CDNs
- **Upgrade-safe** — Module updates don't affect your custom theme or existing configurations
- **Demo pages included** — Visual verification routes to confirm Bootstrap is working correctly

---

## 🆚 Alternatives Considered

| Approach | Why Not Chosen |
| :--- | :--- |
| Manual theme integration | Breaks on theme updates, requires developer expertise |
| Child theme with Bootstrap | Adds maintenance overhead, theme-specific |
| Third-party Bootstrap modules | Often lack CSP compliance or version flexibility |
| CDN injection via layout XML | Requires manual CSP configuration, not admin-configurable |

---

## 🎯 Use Cases

- Local Magento development
- CI/CD pipelines
- Multi-environment setups
- Rapid prototyping of Bootstrap-based UI components
- Adding Bootstrap to existing Magento stores without theme rebuilds

---

## ✨ Key Features

| Feature | Details |
| :--- | :--- |
| 🎛 **Admin-Controlled** | Enable, disable, and configure entirely from the Admin Panel |
| 📦 **Multi-Version Support** | Bootstrap 4.x, 5.2.3, 5.3.3, and 5.3.8 |
| 🌐 **CDN-Based Asset Loading** | jsDelivr, cdnjs (Cloudflare), or unpkg |
| 🔒 **CSP-Compliant** | Ships with a pre-configured `csp_whitelist.xml` |
| 🐞 **Debug Mode** | Optional browser console diagnostics |
| 🎭 **Demo Pages Included** | Frontend routes for visual Bootstrap verification |
| 🧩 **No Theme Modifications** | Zero impact on existing theme templates or layout files |
| 🛡 **GDPR-Safe** | No tracking, analytics, or personal data collection |

---

## 🏗️ Architecture Overview

```
HK2 AddBootstrap5 Module Architecture

┌─────────────────────────────────────────────────────┐
│                    Magento Admin Panel              │
│  Stores → Configuration → HK2 → AddBootstrap5       │
│  [Enable] [Version] [CDN Provider] [Debug Mode]     │
└────────────────────────┬────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                   Configuration Layer               │
│  etc/config.xml (defaults)                          │
│  etc/system.xml (admin fields)                      │
└────────────────────────┬────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                  Asset Injection Layer              │
│  PageConfig API → CSS + JS CDN URLs                 │
│  Layout XML → Frontend page integration             │
└────────────────────────┬────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                   CSP Whitelist Layer               │
│  etc/csp_whitelist.xml                              │
│  cdn.jsdelivr.net, cdnjs.cloudflare.com, unpkg.com  │
└────────────────────────┬────────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────┐
│                  Frontend Storefront                │
│  Bootstrap CSS + JS loaded on every storefront page │
└─────────────────────────────────────────────────────┘
```

---

## 📋 System Requirements

| Requirement | Minimum Version |
| :--- | :--- |
| **Magento Open Source / Commerce** | 2.4.4+ |
| **PHP** | 8.2+ |
| **MySQL** | 8.0+ |
| **MariaDB** | 10.4+ |
| **Composer** | 2.x |
| **HK2 Core (`hk2/core`)** | 1.0.0+ |

> ⚠ **Note:** Magento 2.3.x (EOL) is not supported. PHP 7.x is not supported.

---

## 🚀 Installation

### Composer — Recommended

Automatically installs **HK2 Core** as a dependency:

```bash
composer require hk2/addbootstrap5
php bin/magento module:enable HK2_Core HK2_AddBootstrap5
php bin/magento setup:upgrade
php bin/magento cache:flush
```

### Manual Installation

**1. Prerequisites**

Ensure HK2 Core module is installed:

- Download: [https://github.com/basantmandal/magento2-hk2-core-module/archive/refs/tags/v1.0.0.zip](https://github.com/basantmandal/magento2-hk2-core-module/archive/refs/tags/v1.0.0.zip)
- Place at: `app/code/HK2/Core/`

**2. Configuration**

Place this module files at: `app/code/HK2/AddBootstrap5/`

**3. Start Services**

```bash
php bin/magento module:enable HK2_Core HK2_AddBootstrap5
php bin/magento setup:upgrade
php bin/magento cache:flush
```

**Production mode** (run additionally):

```bash
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy -f
```

> ⚠ **Security Warning:** Always test in a staging environment before deploying to production. Ensure your firewall allows outbound requests to the selected CDN.

> 📖 Full installation details: [docs/installation.md](./docs/installation.md)

---

## ⚙️ Configuration

Navigate to: **Stores → Configuration → HK2 → AddBootstrap5**

| Setting | Description | Default |
| :--- | :--- | :--- |
| Enable Extension | Master on/off switch for Bootstrap injection | `Yes` |
| Bootstrap Version | Select Bootstrap 4.x, 5.2.3, 5.3.3, or 5.3.8 | `5.3.8` |
| CDN Provider | jsDelivr, cdnjs, or unpkg | `jsDelivr` |
| Debug Mode | Log diagnostics to the browser console | `No` |

| Service | Version | Purpose |
| :--- | :--- | :--- |
| **jsDelivr** | Latest | Primary CDN for Bootstrap assets |
| **cdnjs (Cloudflare)** | Latest | Alternative CDN with global edge network |
| **unpkg** | Latest | npm-sourced CDN alternative |

> ⚠ Always flush the Magento cache after saving configuration changes.

---

## 🎯 Demo Pages

The module ships with frontend demo pages for Bootstrap validation:

```bash
# Bootstrap 5
https://yourstore.com/bootstrap5demo/demo/index/version/5

# Bootstrap 4
https://yourstore.com/bootstrap5demo/demo/index/version/4
```

These pages render standard Bootstrap components (grid, cards, buttons, alerts) to visually confirm the integration is working.

---

## 🔒 Content Security Policy (CSP)

The module includes a pre-configured `csp_whitelist.xml` that whitelists the following CDN hosts under Magento 2.4.x strict CSP mode:

| Directive | Allowed Hosts |
| :--- | :--- |
| `script-src` | `cdn.jsdelivr.net`, `cdnjs.cloudflare.com`, `unpkg.com` |
| `style-src` | `cdn.jsdelivr.net`, `cdnjs.cloudflare.com`, `unpkg.com` |
| `img-src` | `www.basantmandal.in` |

The module **never** uses `unsafe-inline` or `unsafe-eval`.

---

## 🔐 Privacy & GDPR

- ✅ No personal data is collected, stored, or transmitted
- ✅ No analytics, tracking scripts, or cookies introduced
- ✅ External requests are limited to selected CDN assets only
- ✅ Fully GDPR-safe by design

---

## 🧪 Testing Strategy

### Manual Testing

1. **Installation Verification:**

   ```bash
   php bin/magento module:status HK2_Core HK2_AddBootstrap5
   ```

2. **Admin Panel Verification:**
   - Navigate to: Stores → Configuration → HK2 → AddBootstrap5
   - Verify all configuration options are present and functional

3. **Frontend Verification:**
   - Visit demo pages to confirm Bootstrap components render correctly
   - Check browser DevTools Network tab for CDN asset loading
   - Verify no CSP errors in browser console

### Automated Testing

- **PHPCS:** Run `vendor/bin/phpcs --standard=phpcs.xml` to verify coding standards
- **Magento EQP:** Use MEQP2 for Magento-specific code quality checks

### Test Environments

| Environment | Magento Version | PHP Version | Status |
| :--- | :--- | :--- | :--- |
| Local Development | 2.4.7 | 8.2 | ✅ Tested |
| Staging | 2.4.6 | 8.2 | ✅ Tested |
| Production | 2.4.7 | 8.3 | ✅ Verified |

---

## 🚀 Production Readiness

### Pre-Deployment Checklist

- [ ] Disable Debug Mode in Admin configuration
- [ ] Test on staging environment with production-like data
- [ ] Verify CSP whitelist is active (if using strict CSP mode)
- [ ] Run `setup:di:compile` and `setup:static-content:deploy -f`
- [ ] Confirm CDN accessibility from your server location
- [ ] Review known limitations for compatibility with your theme

### Performance Considerations

- Bootstrap assets are loaded from CDN with proper caching headers
- No database queries are introduced by this module
- Asset injection occurs only on storefront pages (not admin)
- Debug mode should be disabled in production to avoid console overhead

### Rollback Plan

If issues arise after deployment:

1. Disable the module: `php bin/magento module:disable HK2_AddBootstrap5`
2. Flush cache: `php bin/magento cache:flush`
3. Bootstrap assets will no longer be injected

---

## 📚 Documentation

| Document | Purpose |
| :--- | :--- |
| [**Compatibility**](docs/compatibility.md) | Module compatibility information |
| [**Installation**](docs/installation.md) | Detailed installation instructions |
| [**Usage**](docs/usage.md) | How to use and configure the module |
| [**Changelog**](CHANGELOG.md) | Release history |
| [**Contributing**](.github/CONTRIBUTING.md) | Contribution guidelines |
| [**Security Policy**](SECURITY.md) | Vulnerability reporting |

---

## ⚠️ Known Limitations

- The module **does not restyle Magento UI components** (buttons, tables, forms remain Magento-styled)
- Any CSS conflicts between Bootstrap and the active theme must be resolved at the theme level
- Bootstrap JavaScript components require correct Bootstrap HTML markup to function
- Not recommended for use with **Hyva Theme** without careful CSS conflict testing

---

## 🤝 Contributing

Contributions, bug reports, and feature suggestions are welcome.

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Commit your changes: `git commit -m "feat: add my feature"`
4. Push to your fork: `git push origin feature/my-feature`
5. Open a Pull Request

Please see [CONTRIBUTING.md](./.github/CONTRIBUTING.md) for guidelines.

---

## 📄 License

This module is released under the **Open Software License 3.0 (OSL-3.0)**.

See [LICENCE.txt](./LICENCE.txt) or [https://opensource.org/licenses/OSL-3.0](https://opensource.org/licenses/OSL-3.0)

---

## ⚖️ Disclaimer

This extension is provided **as-is**, without warranty of any kind, express or implied. The author is not liable for any damages arising from its use. Always test in a staging environment before deploying to production.

---

<div align="center">
  <b>Basant Mandal</b><br>
  <a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
  <a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>
  <a href="mailto:support@basantmandal.in"><img src="https://img.shields.io/badge/Email-support%40basantmandal.in-blue?style=flat-square&logo=gmail" alt="Email"></a>
  
  ---
</div>

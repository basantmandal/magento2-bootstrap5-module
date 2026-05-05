# Compatibility Guide

**HK2 AddBootstrap5 for Magento 2** — `hk2/addbootstrap5 v3.0.0`

---

## Table of Contents

- [Platform Requirements](#platform-requirements)
- [Bootstrap Version Support](#bootstrap-version-support)
- [CDN Provider Support](#cdn-provider-support)
- [PHP Version Matrix](#php-version-matrix)
- [Magento Edition Support](#magento-edition-support)
- [Database Compatibility](#database-compatibility)
- [Content Security Policy (CSP)](#content-security-policy-csp)
- [Frontend Theme Compatibility](#frontend-theme-compatibility)
- [Known Incompatibilities](#known-incompatibilities)

---

## Platform Requirements

| Requirement           | Minimum Version | Recommended |
| --------------------- | --------------- | ----------- |
| Magento Open Source   | 2.4.4           | 2.4.7+      |
| Adobe Commerce        | 2.4.4           | 2.4.7+      |
| PHP                   | 8.2             | 8.2 / 8.3   |
| Composer              | 2.x             | 2.x         |
| MySQL                 | 8.0             | 8.0+        |
| MariaDB               | 10.4            | 10.6+       |
| HK2 Core (`hk2/core`) | 1.0.0           | Latest      |

> ⚠ **Magento 2.3.x is end-of-life and is not supported.** PHP 7.x is not supported.

---

## Bootstrap Version Support

The module supports loading Bootstrap directly from CDN. The following versions have been tested and validated:

| Bootstrap Version | Status           | Notes                              |
| ----------------- | ---------------- | ---------------------------------- |
| **5.3.8**         | ✅ Stable        | Default. Recommended for new sites |
| **5.3.3**         | ✅ Stable        | Production-ready                   |
| **5.2.3**         | ✅ Stable        | Supported, not actively maintained |
| **4.x (latest)**  | ✅ Stable        | Legacy support, no new features    |
| 3.x and below     | ❌ Not supported | Out of scope                       |

> The Bootstrap version is selected from the Admin Panel — no code changes are required to switch versions.

---

## CDN Provider Support

All CDN providers below are whitelisted in the module's `csp_whitelist.xml` and verified to serve Bootstrap assets reliably.

| CDN Provider           | Host                   | Supported |
| ---------------------- | ---------------------- | --------- |
| **jsDelivr**           | `cdn.jsdelivr.net`     | ✅ Yes    |
| **cdnjs (Cloudflare)** | `cdnjs.cloudflare.com` | ✅ Yes    |
| **unpkg**              | `unpkg.com`            | ✅ Yes    |

> **Default CDN:** jsDelivr (`cdn.jsdelivr.net`)

---

## PHP Version Matrix

| PHP Version | Magento 2.4.4  | Magento 2.4.6 | Magento 2.4.7 |
| ----------- | -------------- | ------------- | ------------- |
| **8.2**     | ✅             | ✅            | ✅            |
| **8.3**     | ⚠ Experimental | ✅            | ✅            |
| 8.1         | ✅             | ✅            | ⚠             |
| 7.x         | ❌             | ❌            | ❌            |

---

## Magento Edition Support

| Edition                         | Supported |
| ------------------------------- | --------- |
| Magento Open Source (Community) | ✅ Yes    |
| Adobe Commerce (On-Premise)     | ✅ Yes    |
| Adobe Commerce Cloud            | ✅ Yes    |
| Magento 2.3.x (EOL)             | ❌ No     |

---

## Database Compatibility

This module does **not** create or modify any database tables. No schema changes or data patches are introduced. It is compatible with all database engines supported by Magento 2.4.x.

| Database | Version | Supported |
| -------- | ------- | --------- |
| MySQL    | 8.0+    | ✅ Yes    |
| MariaDB  | 10.4+   | ✅ Yes    |

---

## Content Security Policy (CSP)

The module ships with a pre-configured `csp_whitelist.xml` for Magento 2.4.x strict CSP mode.

### Whitelisted Directives

| Directive    | Allowed Hosts                                           |
| ------------ | ------------------------------------------------------- |
| `script-src` | `cdn.jsdelivr.net`, `cdnjs.cloudflare.com`, `unpkg.com` |
| `style-src`  | `cdn.jsdelivr.net`, `cdnjs.cloudflare.com`, `unpkg.com` |
| `img-src`    | `www.basantmandal.in`                                   |

The module does **not** use:

- `unsafe-inline`
- `unsafe-eval`
- Inline `<script>` or `<style>` tags

> ✅ Fully compliant with Magento 2.4.7 default strict CSP mode.

---

## Frontend Theme Compatibility

The module injects Bootstrap via Magento's `PageConfig` and layout XML — it does **not** modify any theme files.

| Theme                   | Compatibility                            |
| ----------------------- | ---------------------------------------- |
| Magento Blank (default) | ✅ Compatible                            |
| Magento Luma            | ✅ Compatible                            |
| Hyva Theme              | ⚠ See note                               |
| Custom themes           | ✅ Compatible                            |
| Third-party themes      | ✅ Compatible (verify styling conflicts) |

> ⚠ **Hyva Theme Note:** Hyva uses Alpine.js and Tailwind CSS and intentionally avoids jQuery and Bootstrap. Loading Bootstrap in a Hyva theme may cause CSS conflicts. Testing is strongly recommended.

---

## Known Incompatibilities

| Scenario                                          | Impact      | Resolution                                                   |
| ------------------------------------------------- | ----------- | ------------------------------------------------------------ |
| Bootstrap JS conflicting with jQuery UI dialogs   | Medium      | Scope Bootstrap JS usage to non-admin pages                  |
| CSS specificity conflicts with existing theme     | Low–Medium  | Override conflicting styles in theme CSS                     |
| Hyva theme — CSS layout conflicts                 | Medium–High | Disable module or scope to specific pages via layout handles |
| CSP strict mode with custom CDN (not whitelisted) | High        | Add CDN host to `csp_whitelist.xml` manually                 |

---

## Related

- [Installation Guide](./installation.md)
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

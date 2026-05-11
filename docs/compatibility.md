# Compatibility Guide

## Magento Versions

HK2_AddBootstrap5 is compatible with Magento **2.4.x** across all editions:

| Magento Edition | Compatibility |
|---|---|
| Magento Open Source 2.4.x | Yes |
| Adobe Commerce (formerly Magento Commerce) 2.4.x | Yes |
| Adobe Commerce Cloud 2.4.x | Yes |

The module requires `magento/framework` **^103.0.0**, which corresponds to the Magento 2.4.x release line.

### Module sequence

The module loads after the following modules (defined in `etc/module.xml`):

| Module | Purpose |
|---|---|
| `HK2_Core` | Shared HK2 admin tab, menu root, module header block |
| `Magento_Backend` | Admin routing and menu infrastructure |
| `Magento_Config` | System configuration framework |
| `Magento_Store` | Store and website scope handling |

These dependencies ensure that the HK2 admin tab (`hk2_options_tab`), the HK2 menu parent (`HK2::root`), and the system configuration framework are fully initialized before HK2_AddBootstrap5 registers its fields.

## PHP Versions

| PHP Version | Compatibility |
|---|---|
| 8.1 | Fully supported |
| 8.2 | Fully supported |
| 8.3 | Fully supported |
| 8.4 | Fully supported |

The `composer.json` requires `^8.1 || ^8.2 || ^8.3 || ^8.4`, and the PHPCS configuration targets `testVersion="8.2-"` to ensure forward compatibility.

## Supported Bootstrap Versions

| Bootstrap Version | Included |
|---|---|
| 4.4.1 | Yes |
| 4.5.3 | Yes |
| 4.6.2 | Yes |
| 5.0.2 | Yes |
| 5.1.3 | Yes |
| 5.2.3 | Yes |
| 5.3.8 | Yes (default) |

## Browser Compatibility

The Bootstrap files loaded from CDN carry their own browser support matrix. Bootstrap 4 supports Internet Explorer 10+ and all modern browsers. Bootstrap 5 drops Internet Explorer support entirely and targets all modern browsers (Chrome, Firefox, Safari, Edge).

## Dependency Compatibility Matrix

| Dependency | Required Version | Notes |
|---|---|---|
| `hk2/core` | `^1.0` | Shared HK2 foundation module; provides admin tab, menu parent, and module header |
| `magento/framework` | `^103.0.0` | Core Magento framework; ships with Magento 2.4.x |
| `php` | `^8.1 \|\| ^8.2 \|\| ^8.3 \|\| ^8.4` | All supported PHP 8.x lines |

No other third-party Composer dependencies are required.

## Upgrade Compatibility

- **No breaking schema changes** -- The module defines no database tables, columns, or EAV attributes. Upgrades between versions are purely XML and PHP configuration changes.
- **No setup patches** -- The module has no `Setup` directory or patch classes. Version bumps in `module.xml` are informational only.
- **Backward compatible** -- The public API consists of the `BootstrapAssets` block class, the `BootstrapVersion` and `CdnProvider` source models, and the configuration path constants. These identifiers will not change without a major version bump.

## Sibling Module Compatibility

HK2_AddBootstrap5 depends on HK2_Core and can be installed alongside other HK2 modules without conflicts:

| Module | Composer Package | Notes |
|---|---|---|
| HK2_Core | `hk2/core` | Required dependency |
| HK2_CspWhitelisting | `hk2/csp-whitelisting` | Independent -- no shared concerns |
| HK2_SanitizeSearch | `hk2/search-sanitizer` | Independent -- no shared concerns |
| HK2_ScrollTop | `hk2/scrolltop` | Independent -- no shared concerns |

All HK2 modules that depend on HK2_Core share the same admin tab (`hk2_options_tab`) and menu parent (`HK2::root`), ensuring a consistent admin experience.

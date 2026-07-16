# HK2 Add Bootstrap 5

![Version](https://img.shields.io/badge/version-3.0.0-blue?style=flat-square)
![License](https://img.shields.io/badge/license-OSL--3.0-green?style=flat-square)
![Magento](https://img.shields.io/badge/Magento-2.4.4--2.4.9-f97316?style=flat-square&logo=magento&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1%20%7C%7C%208.2%20%7C%7C%208.3%20%7C%7C%208.4-7c3aed?style=flat-square&logo=php&logoColor=white)
[![Downloads](https://img.shields.io/packagist/dt/hk2/addbootstrap5?style=flat-square)](https://packagist.org/packages/hk2/addbootstrap5)

## Overview

HK2 Add Bootstrap 5 is a Magento 2 extension that enables store administrators to load Bootstrap 4 or Bootstrap 5 on the storefront. This is accomplished without modifying any theme files or creating child themes, allowing for rapid and modular frontend design integration.

## 🎯 Use Cases

- **Custom Styling**: Easily style storefront templates with Bootstrap utilities.
- **Theme Development**: Prototyping pages and layouts without setting up local asset pipelines.

## 🚀 Features

- 🎨 Integrates Bootstrap 4 or 5 onto the storefront without child themes.
- ⚡ Asynchronously loads JS via a RequireJS-compatible inclusion pattern.
- ⚙️ Adds an Admin Panel configuration for selecting version and CDN provider.
- 🛠 Provides a demo route (`addbootstrap5/demo/index`) to verify styles.
- 🔒 Whitelists CDNs in `etc/csp_whitelist.xml` to prevent CSP violations.

## 🏗 Architecture

- **Block**: `HK2\AddBootstrap5\Block\Bootstrap\BootstrapAssets` manages stylesheet and javascript dynamic inclusion logic.
- **Controller**: `HK2\AddBootstrap5\Controller\Demo\Index` serves the Bootstrap demonstration page.

## 🧩 Magento Components

### Blocks

- `HK2\AddBootstrap5\Block\Bootstrap\BootstrapAssets`
- `HK2\AddBootstrap5\Block\Demo\Index`
- `HK2\AddBootstrap5\Block\Adminhtml\System\Config\DemoLinkV4`
- `HK2\AddBootstrap5\Block\Adminhtml\System\Config\DemoLinkV5`

### Controllers

- `HK2\AddBootstrap5\Controller\Demo\Index`

### Layout XML

- `view/frontend/layout/default.xml` - Loads asset inclusion block.
- `view/frontend/layout/addbootstrap5_demo_index.xml` - Sets up the demo page layout.

## 📦 Requirements

- **Magento version**: 2.4.4 - 2.4.9
- **PHP requirements**: 8.1 || 8.2 || 8.3 || 8.4
- **Required Extension**: `HK2_Core`

## ⚙️ Installation

1. `composer require hk2/addbootstrap5`
2. `bin/magento module:enable HK2_AddBootstrap5`
3. `bin/magento setup:upgrade`
4. `bin/magento setup:di:compile`
5. `bin/magento cache:flush`

## 🔧 Configuration

Configure settings under **Stores > Configuration > HK2 > Add Bootstrap5**:

| Field | Description |
|-------|-------------|
| **Enable Extension** | Enable or disable the Bootstrap asset loading globally. |
| **Select Bootstrap Version** | Choose Bootstrap 4 (4.4.1, 4.5.3, 4.6.2) or 5 (5.0.2, 5.1.3, 5.2.3, 5.3.8). |
| **Select CDN Provider** | Select CDN host (`jsDelivr`, `cdnjs`, `unpkg`). |
| **Enable Debug Mode** | If enabled, prints version and CDN metadata to the browser console. |

## Usage

Navigate to the frontend route `{{base_url}}/addbootstrap5/demo/index` to verify that Bootstrap is working. You can append `?version=4` or `?version=5` to test respective versions.

## 🗄 Database Changes

Not Applicable

## 📂 Module Structure

```text
Block/
├── Adminhtml/
│   └── System/
│       └── Config/
│           ├── DemoLinkV4.php
│           └── DemoLinkV5.php
├── Bootstrap/
│   └── BootstrapAssets.php
└── Demo/
    └── Index.php
Controller/
└── Demo/
    └── Index.php
etc/
├── adminhtml/
│   ├── menu.xml
│   ├── routes.xml
│   └── system.xml
├── frontend/
│   └── routes.xml
├── acl.xml
├── config.xml
├── csp_whitelist.xml
└── module.xml
view/
└── frontend/
    ├── layout/
    │   ├── addbootstrap5_demo_index.xml
    │   └── default.xml
    ├── templates/
    │   ├── bootstrap/
    │   │   └── include.phtml
    │   └── demo/
    │       └── index.phtml
    └── web/
        └── js/
            └── bootstrap-debug.js
```

## 📈 Performance Considerations

The JS bundle is loaded asynchronously and only after the load event, preventing blocking of DOM layout calculations.

## 🔐 Security Considerations

- **CSP Whitelisting**: Out-of-the-box whitelisting for CDNs (jsDelivr, unpkg, cdnjs) is configured in `etc/csp_whitelist.xml` to satisfy standard Magento Content Security Policies.

## Compatibility

Reference: [docs/compatibility.md](docs/compatibility.md)

| Platform | Supported Versions |
|----------|-------------------|
| Magento  | 2.4.4 - 2.4.9     |
| PHP      | 8.1, 8.2, 8.3, 8.4 |

## 🛠 Troubleshooting

### RequireJS/AMD Conflicts

If third-party scripts fail with AMD conflicts on the page after enabling Bootstrap, the RequireJS-wrapper inside `include.phtml` restores `window.define.amd` safely. Ensure no other module interferes with script loads.

### CSP Errors in Console

Verify that the `HK2_Csp` module is active or that your web server allows connections to selected CDNs.

## 🤝 Contributing

Contributions are welcome! If you'd like to improve the installer:

- ⭐ **Star this repository** (Helps others find it!)
- 🍴 Fork the project
- 🐛 Report bugs
- 💡 Suggest new features
- 🤝 Contribute improvements

Every ⭐ helps increase the visibility of the project and motivates further development.

## ⚖️ Disclaimer

The author provides this installation script "as is" without any warranties. Users are responsible for ensuring that running this script complies with their internal security and software requirements.

---

## 🤝 Support

For bug reports, feature requests, and general support:

- **Author**: Basant Mandal
- **Email**: <support@basantmandal.in>
- **Website**: <https://www.basantmandal.in>

## License

This project is licensed under the OSL 3.0 License. See the [LICENSE.txt](LICENSE.txt) file for details.

---

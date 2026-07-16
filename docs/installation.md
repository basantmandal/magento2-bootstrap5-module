# HK2 Add Bootstrap 5

## Overview

HK2 Add Bootstrap 5 is a Magento 2 extension that enables storefront administrators to load Bootstrap 4 or Bootstrap 5 on pages. It operates without theme edits, pulling packages dynamically from reputable CDNs.

## 📦 Installation

### ⚙️ Install Package

```bash
composer require hk2/addbootstrap5
```

> This installs the module and its dependency `hk2/core ^1.0`.

### Step-1: Enable Module

```bash
bin/magento module:enable HK2_AddBootstrap5
```

### Step-2: Upgrade Database

```bash
bin/magento setup:upgrade
```

### Step-3: Compile

```bash
bin/magento setup:di:compile
```

### Step-4: Flush Cache

```bash
bin/magento cache:flush
```

### Step-5: Verification

To verify that the module is successfully installed:
1. Navigating to the admin panel under **Stores > Configuration > HK2 > Add Bootstrap5** should render the settings section.
2. In the browser, navigate to the route `{{base_url}}/addbootstrap5/demo/index` to see the Bootstrap verification alert and widgets.

## 🛠 Uninstallation

### Step-1: Disable Module

```bash
bin/magento module:disable HK2_AddBootstrap5
```

### Step-2: Remove Package

```bash
composer remove hk2/addbootstrap5
```

### Step-3: Upgrade

```bash
bin/magento setup:upgrade
```

### Step-4: Flush Cache

```bash
bin/magento cache:flush
```

### Step-5: Verification

Verify that navigating to `addbootstrap5/demo/index` results in a 404 page, and that Bootstrap styles are no longer injected on the storefront.

## 🛠 Troubleshooting

### Module not detected
Ensure that the code is in the correct directory `app/code/HK2/AddBootstrap5/` and that the file permissions allow Magento to read the module files. Run `bin/magento setup:upgrade` to register the module.

### Composer conflicts
Verify that `hk2/core` is successfully installed as it is a required dependency.

### Setup upgrade failures
Ensure that your database connection is active and that your database user has sufficient privileges to perform schema/data updates.

### Compilation failures
If Dependency Injection compilation (`setup:di:compile`) fails, clear the generated code directory by running `rm -rf generated/code/* generated/metadata/*` and retry compilation.

### Cache issues
If changes do not appear after installation or uninstallation, flush the cache using `bin/magento cache:flush` and clean the cache with `bin/magento cache:clean`.

### Permissions issues
Ensure the Magento files and directories are owned by the correct web user and have the appropriate write permissions. Run standard Magento permission fixes:
```bash
find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
```

### PHP compatibility issues
This module requires PHP 8.1, 8.2, 8.3, or 8.4. Verify your current CLI PHP version using `php -v`.

## 🤝 Support

For bug reports, feature requests, and general support:

- **Author**: Basant Mandal
- **Email**: support@basantmandal.in
- **Website**: https://www.basantmandal.in

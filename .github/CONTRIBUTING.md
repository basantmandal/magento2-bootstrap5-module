<div align="center">

# Contributing to HK2 AddBootstrap5

**First off, thank you for considering contributing to the HK2 AddBootstrap5 Module! It's people like you that make it such a great tool.**

<img src="https://img.shields.io/badge/version-3.0.0-blue?style=flat-square" alt="Version">
<img src="https://img.shields.io/badge/license-OSL--3.0-green?style=flat-square" alt="License">
<a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
<a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>

</div>

---

## 👋 Introduction

Welcome to the **HK2 AddBootstrap5** contributing guide! This document provides guidelines and instructions for contributing to this Magento 2 extension.

Whether you're fixing a bug, adding a feature, or improving documentation — your contributions are highly appreciated. All contributions help make this extension better for the entire Magento community.

---

## 🐛 Reporting Bugs

Before creating bug reports, please check existing issues to avoid duplicates.

**When creating a bug report, please include:**

- **Clear title and description** of the issue
- **Steps to reproduce** the behavior
- **Expected behavior** vs **actual behavior**
- **Environment details**: Magento version, PHP version, module version
- **Screenshots or logs** if applicable

> 💡 **Tip:** Use our [Bug Report Template](ISSUE_TEMPLATE/bug_report.yml) when creating an issue for a structured report.

---

## 💡 Suggesting Enhancements

Enhancement suggestions are welcome! When suggesting a feature:

- **Use a clear and descriptive title**
- **Provide a detailed description** of the proposed functionality
- **Explain why this enhancement would be useful** to users
- **Include examples or mockups** if possible

---

## 🛠️ Pull Requests

### Process

1. **Fork the repository** and create your branch from `main`
2. **Make your changes** following the coding standards below
3. **Test your changes** thoroughly in a Magento 2.4.x environment
4. **Update documentation** if your changes affect functionality
5. **Submit a Pull Request** with a clear description of changes

### PR Requirements

- [ ] Code follows Magento 2 coding standards (PSR-12)
- [ ] Commit messages follow [Conventional Commits](https://www.conventionalcommits.org/) specification
- [ ] Changes are tested on Magento 2.4.x with PHP 8.2+
- [ ] Documentation is updated if applicable
- [ ] No breaking changes without major version bump

### Commit Message Format

We follow [Conventional Commits](https://www.conventionalcommits.org/):

```
type(scope): description

[optional body]

[optional footer]
```

**Types:**

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting, semicolons, etc.)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

**Example:**

```
feat(cdn): add support for unpkg CDN provider
```

---

## 🧑‍💻 Coding Standards

This project follows Magento 2 coding standards:

- **PHP:** PSR-12 coding standard
- **Magento EQP:** MEQP2 coding standard
- **Code sniffing:** Run `phpcs` before submitting PRs

### PHPCS Configuration

The project includes a `phpcs.xml` configuration file. Run:

```bash
vendor/bin/phpcs --standard=phpcs.xml
```

### Module Structure

Follow Magento 2 module structure:

```
app/code/HK2/AddBootstrap5/
├── Controller/
├── etc/
├── Model/
├── view/
├── registration.php
└── composer.json
```

---

## 📚 Additional Resources

- [Magento 2 Developer Documentation](https://developer.adobe.com/commerce/php/)
- [Magento Coding Standard](https://github.com/magento/magento-coding-standard)
- [Conventional Commits](https://www.conventionalcommits.org/)

---

<div align="center">
  <b>Basant Mandal</b><br>
  <a href="https://www.basantmandal.in/"><img src="https://img.shields.io/badge/Website-000?style=flat-square&logo=ko-fi&logoColor=white" alt="Website"></a>
  <a href="https://www.linkedin.com/in/basantmandal/"><img src="https://img.shields.io/badge/LinkedIn-0A66C2?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn"></a>
  <a href="mailto:support@basantmandal.in"><img src="https://img.shields.io/badge/Email-support%40basantmandal.in-blue?style=flat-square&logo=gmail" alt="Email"></a>
  
  ---
</div>

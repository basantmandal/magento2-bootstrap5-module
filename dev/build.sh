#!/usr/bin/env bash
set -e

# --------------------------------------------------
# Parse arguments
# --------------------------------------------------
FIX_MODE=false
for arg in "$@"; do
  if [[ "$arg" == "--fix" ]]; then
    FIX_MODE=true
  fi
done

# --------------------------------------------------
# Resolve module directory (script location)
# --------------------------------------------------
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
MODULE_DIR="$(dirname "$SCRIPT_DIR")"

MODULE_NAME="$(basename "$MODULE_DIR")"
VENDOR="$(basename "$(dirname "$MODULE_DIR")")"

VENDOR="HK2"

# --------------------------------------------------
# Find Magento root (walk up until app/code exists)
# --------------------------------------------------

find_magento_root() {
  local dir="$MODULE_DIR"
  while [ "$dir" != "/" ]; do
    if [ -d "$dir/app/code" ] && [ -f "$dir/bin/magento" ]; then
      echo "$dir"
      return
    fi
    dir="$(dirname "$dir")"
  done

  echo "❌ Magento root not found"
  exit 1
}

PROJECT_ROOT="$(find_magento_root)"

# --------------------------------------------------
# Build directory INSIDE the module
# --------------------------------------------------
BUILD_DIR="$MODULE_DIR/build"
mkdir -p "$BUILD_DIR"

PHP_BIN="${PHP_BIN:-php}"
PHPCS_BIN="$PROJECT_ROOT/vendor/bin/phpcs"
PHPCBF_BIN="$PROJECT_ROOT/vendor/bin/phpcbf"

clear
echo "🔍 Testing Magento module: $VENDOR/$MODULE_NAME"
echo "📁 Module path: $MODULE_DIR"
echo "🏠 Magento root: $PROJECT_ROOT"

# --------------------------------------------------
# 0. Sanity checks
# --------------------------------------------------
if [ ! -x "$PHPCS_BIN" ]; then
  echo "❌ PHPCS not found at $PHPCS_BIN"
  echo "👉 Run: composer install from Magento root"
  exit 1
fi

if $FIX_MODE && [ ! -x "$PHPCBF_BIN" ]; then
  echo "❌ PHPCBF not found at $PHPCBF_BIN"
  echo "👉 Run: composer install from Magento root"
  exit 1
fi

# --------------------------------------------------
# Optional auto-fix using PHPCBF
# --------------------------------------------------
if $FIX_MODE; then
  echo "▶ Auto-fixing code with PHPCBF..."
  "$PHPCBF_BIN" --standard="$SCRIPT_DIR/dev/phpcs.xml" "$MODULE_DIR"
  echo "✅ PHPCBF completed"
fi

# --------------------------------------------------
# 1. PHP syntax check
# --------------------------------------------------
echo "▶ Checking PHP syntax"
find "$MODULE_DIR" -name "*.php" ! -path "*/docs/*" -print0 \
  | xargs -0 -n1 "$PHP_BIN" -l

# --------------------------------------------------
# 2. Magento Coding Standard
# --------------------------------------------------
echo "▶ Running Magento Coding Standard (Magento2)"
echo "▶ Using - $SCRIPT_DIR/phpcs.xml"
"$PHPCS_BIN" \
  --standard="$SCRIPT_DIR/phpcs.xml" \
  --extensions=php,phtml \
  --ignore="**/*.css,**/*.less,**/*.js" \
  "$MODULE_DIR"

# --------------------------------------------------
# 3. PHP Compatibility (PHP 8.2)
# --------------------------------------------------
echo "▶ Running PHPCompatibility (PHP 8.2)"
"$PHPCS_BIN" \
  --standard=PHPCompatibility \
  --runtime-set testVersion 8.2 \
  --ignore="**/*.css,**/*.less,**/*.js" \
  "$MODULE_DIR"

# --------------------------------------------------
# 4. Forbidden ObjectManager usage
# --------------------------------------------------
echo "▶ Checking for direct ObjectManager usage"

OM_MATCHES=$(grep -R --line-number \
  --include="*.php" \
  --include="*.phtml" \
  --exclude-dir="docs" \
  "ObjectManager::getInstance" "$MODULE_DIR" || true)

if [ -n "$OM_MATCHES" ]; then
  echo "❌ Direct ObjectManager usage found:"
  echo "$OM_MATCHES"
  exit 1
fi

# --------------------------------------------------
# 5. Forbidden debug output
# --------------------------------------------------
echo "▶ Checking for debug output"

DEBUG_MATCHES=$(grep -R --line-number -E \
  "\b(var_dump|print_r|die\(|exit\(|echo )" \
  --include="*.php" \
  --include="*.phtml" \
  --exclude-dir="docs" \
  "$MODULE_DIR" || true)

if [ -n "$DEBUG_MATCHES" ]; then
  echo "❌ Debug output found:"
  echo "$DEBUG_MATCHES"
  exit 1
fi

# --------------------------------------------------
# 6. Required Magento files
# --------------------------------------------------
echo "▶ Verifying required Magento files"

REQUIRED_FILES=(
  "registration.php"
  "etc/module.xml"
)

for FILE in "${REQUIRED_FILES[@]}"; do
  if [ ! -f "$MODULE_DIR/$FILE" ]; then
    echo "❌ Missing required file: $FILE"
    exit 1
  fi
done



# --------------------------------------------------
# 7. Validating composer.json
# --------------------------------------------------
echo "▶ Validating composer.json"

composer validate --strict "$MODULE_DIR/composer.json"


# --------------------------------------------------
# 8. Running PHPStan (if available)
# --------------------------------------------------

if [ -x "$PHPSTAN_BIN" ]; then
  echo "▶ Running PHPStan"

  "$PHPSTAN_BIN" analyse \
    -c "$MODULE_DIR/dev/phpstan.neon"
else
  echo "⚠️ PHPStan not installed"
fi

# --------------------------------------------------
# 9. Checking for forbidden functions (e.g. eval, exec, etc.)
# --------------------------------------------------

FORBIDDEN_FUNCTIONS=(
  "base64_decode("
  "eval("
  "exec("
  "shell_exec("
  "passthru("
  "system("
  "proc_open("
)

for fn in "${FORBIDDEN_FUNCTIONS[@]}"; do
  MATCHES=$(grep -R --line-number \
    --include="*.php" \
    "$fn" \
    "$MODULE_DIR" || true)

  if [ -n "$MATCHES" ]; then
    echo "❌ Forbidden function found: $fn"
    echo "$MATCHES"
    exit 1
  fi
done

# --------------------------------------------------
# 10. Running PHPCPD for duplicate code detection (if available)
# --------------------------------------------------

PHPCPD_BIN="$PROJECT_ROOT/vendor/bin/phpcpd"

if [ -x "$PHPCPD_BIN" ]; then
  echo "▶ Running PHPCPD"

  "$PHPCPD_BIN" "$MODULE_DIR"
fi

echo "✅ All checks passed successfully"

# --------------------------------------------------
# 11. Build ZIP (using .zipignore)
# --------------------------------------------------
VERSION=$(sed -n 's/.*setup_version="\([^"]*\)".*/\1/p' "$MODULE_DIR/etc/module.xml")
BUILD_TIME=$(date +"%Y%m%d-%H%M")
ZIP_NAME="${VENDOR}_${MODULE_NAME}_${VERSION}_${BUILD_TIME}.zip"

echo "▶ Creating ZIP: $ZIP_NAME"

cd "$PROJECT_ROOT" || exit 1

ZIPIGNORE_FILE="$MODULE_DIR/dev/.zipignore"

if [ ! -f "$ZIPIGNORE_FILE" ]; then
  echo "⚠️ .zipignore not found, proceeding without exclusions file"
  zip -r "$BUILD_DIR/$ZIP_NAME" "app/code/$VENDOR/$MODULE_NAME"
else
  # Convert .zipignore → zip -x format
  EXCLUDES=()

  while IFS= read -r line || [ -n "$line" ]; do
    # skip comments and empty lines
    [[ "$line" =~ ^#.*$ || -z "$line" ]] && continue

    # normalize path for zip context
    EXCLUDES+=("-x" "app/code/$VENDOR/$MODULE_NAME/$line")
  done < "$ZIPIGNORE_FILE"

  zip -r "$BUILD_DIR/$ZIP_NAME" "app/code/$VENDOR/$MODULE_NAME" "${EXCLUDES[@]}"
fi


echo "✅ Module ready for Adobe Extension Hub"
echo "📦 Output: $BUILD_DIR/$ZIP_NAME"

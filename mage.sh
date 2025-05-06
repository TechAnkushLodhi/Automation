#!/bin/bash

# Magento base path
BASE_PATH="/var/www/html/mage247p4"
cd $BASE_PATH

# Magento command shortcut
MAGENTO="sudo php bin/magento"
# Theme base path
Theme_BASE="app/design/frontend"

# Module base path
Module_BASE="app/code"

# Colors (optional)
GREEN='\033[0;32m'
NC='\033[0m' # No Color

# ---- Function: Reusable Magento Upgrade ----
run_magento_upgrade() {
  echo -e "${GREEN}Running Dev Upgrade Flow...${NC}"
  $MAGENTO setup:upgrade
  $MAGENTO setup:di:compile
  $MAGENTO setup:static-content:deploy -f
  $MAGENTO indexer:reindex
  $MAGENTO cache:clean
  $MAGENTO cache:flush

  echo -e "${GREEN}✅ Magento commands executed.${NC}"
}

echo -e "${GREEN}Magento DevOps Helper Script${NC}"
echo "----------------------------------"

# Check input command
case "$1" in
  upd)
    run_magento_upgrade
    ;;

  upp)
    echo -e "${GREEN}Running Production Upgrade Flow...${NC}"
    $MAGENTO maintenance:enable
    composer install
    run_magento_upgrade
    $MAGENTO maintenance:disable
    ;;

  clean)
    echo -e "${GREEN}Cleaning Cache and Generated Code...${NC}"
    $MAGENTO cache:clean
    $MAGENTO cache:flush
    rm -rf generated/code/*
    rm -rf var/cache/*
    rm -rf var/view_preprocessed/*
    ;;

  deploy)
    echo -e "${GREEN}Static Content Deploying...${NC}"
    $MAGENTO setup:static-content:deploy -f
    ;;

  compile)
    echo -e "${GREEN}Running DI Compile...${NC}"
    $MAGENTO setup:di:compile
    ;;

  permissions)
    echo -e "${GREEN}Fixing folder permissions...${NC}"
    find var generated vendor pub/static pub/media app/etc -type f -exec chmod 644 {} \;
    find var generated vendor pub/static pub/media app/etc -type d -exec chmod 755 {} \;
    chown -R www-data:www-data .
    ;;

  fa)
    echo -e "${GREEN}Fixing secure access for web server...${NC}"
    sudo chown -R ankushubuntu:www-data .
    sudo find . -type f -exec chmod 644 {} \;
    sudo find . -type d -exec chmod 755 {} \;
    sudo chmod -R g+w var pub/static pub/media generated
    ;;

  backup-db)
    echo -e "${GREEN}Taking DB Backup...${NC}"
    TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
    mysqldump -u root -p mage247p4 > db_backup_$TIMESTAMP.sql
    ;;

clear-logs)
    echo -e "${GREEN}Clearing Magento logs...${NC}"
    > var/log/system.log
    > var/log/exception.log
    ;;

# Create new module
create-module)
    echo -e "${GREEN}Scaffolding New Module...${NC}"

    MODULE_BASE="app/code"
    read -p "Vendor Name (e.g. Icecube): " VENDOR

    if [ -d "$MODULE_BASE/$VENDOR" ]; then
        echo -e "${YELLOW}⚠️  Vendor '$VENDOR' already exists.${NC}"
        read -p "Do you want to continue with this vendor? (y/n): " CONFIRM_VENDOR
        if [[ "$CONFIRM_VENDOR" != "y" && "$CONFIRM_VENDOR" != "Y" ]]; then
            echo -e "${RED}❌ Aborting module creation.${NC}"
            exit 1
        fi
    fi

    read -p "Module Name (e.g. EavManager): " MODULE

    MODULE_PATH="$MODULE_BASE/$VENDOR/$MODULE"
    mkdir -p "$MODULE_PATH"/{etc,Controller,Model,view/frontend}

    # registration.php
    cat <<EOF > "$MODULE_PATH/registration.php"
<?php
/**
 * @author Ankush Lodhi
 * @package ${VENDOR}_${MODULE}
 */
\\Magento\\Framework\\Component\\ComponentRegistrar::register(
    \\Magento\\Framework\\Component\\ComponentRegistrar::MODULE,
    '${VENDOR}_${MODULE}',
    __DIR__
);
EOF

    # module.xml
    cat <<EOF > "$MODULE_PATH/etc/module.xml"
<?xml version="1.0"?>
<!--
/**
 * @author Ankush Lodhi
 * @package ${VENDOR}_${MODULE}
 */
-->
<config xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Module/etc/module.xsd">
    <module name="${VENDOR}_${MODULE}" setup_version="1.0.0">
        <sequence>
            <module name="Magento_Customer"/>
            <module name="Magento_Checkout"/>
            <module name="Magento_Sales"/>
        </sequence>
    </module>
</config>
EOF

    echo -e "${GREEN}✅ Module ${VENDOR}_${MODULE} created at: $MODULE_PATH${NC}"

    read -p "Do you want to run Magento upgrade commands now? (y/n): " RUN_CMD
    if [[ "$RUN_CMD" == "y" || "$RUN_CMD" == "Y" ]]; then
        run_magento_upgrade
    fi
    ;;



# Create new theme
create-theme)
    echo -e "${GREEN}Scaffolding New Theme...${NC}"

    read -p "Vendor Name (e.g. Icecube): " VENDOR
    if [ -d "$Theme_BASE/$VENDOR" ]; then
        echo -e "${RED}⚠️  Vendor '$VENDOR' already exists.${NC}"
        read -p "Do you want to continue with this vendor? (y/n): " CONFIRM_VENDOR
        if [[ "$CONFIRM_VENDOR" != "y" && "$CONFIRM_VENDOR" != "Y" ]]; then
            echo -e "${RED}❌ Aborting theme creation.${NC}"
            exit 1
        fi
    fi

    read -p "Theme Name (e.g. Custom): " THEME
    read -p "Select Parent Theme (0: Magento/blank, 1: Magento/luma): " PARENT_CHOICE

    if [ "$PARENT_CHOICE" == "0" ]; then
        PARENT="Magento/blank"
    elif [ "$PARENT_CHOICE" == "1" ]; then
        PARENT="Magento/luma"
    else
        echo -e "${RED}❌ Invalid parent theme selection. Exiting.${NC}"
        exit 1
    fi

    THEME_PATH="$Theme_BASE/$VENDOR/$THEME"
    mkdir -p "$THEME_PATH/etc"

    # theme.xml
    cat <<EOF > "$THEME_PATH/theme.xml"
<?xml version="1.0"?>
<theme xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="urn:magento:framework:Config/etc/theme.xsd">
    <title>$THEME</title>
    <parent>$PARENT</parent>
</theme>
EOF

    # registration.php
    cat <<EOF > "$THEME_PATH/registration.php"
<?php
/**
 * @author Ankush Lodhi
 * @package $THEME
 */
\\Magento\\Framework\\Component\\ComponentRegistrar::register(
    \\Magento\\Framework\\Component\\ComponentRegistrar::THEME,
    'frontend/$VENDOR/$THEME',
    __DIR__
);
EOF

    echo -e "${GREEN}✅ Theme created at: $THEME_PATH${NC}"

    read -p "Do you want to run Magento upgrade commands now? (y/n): " RUN_CMD
    if [[ "$RUN_CMD" == "y" || "$RUN_CMD" == "Y" ]]; then
        run_magento_upgrade
    fi
    ;;

# Create new block
create-block)
    echo -e "${GREEN}Scaffolding New Block...${NC}"

    MODULE_BASE="app/code"

    read -p "Vendor Name (e.g. Icecube): " VENDOR

    if [ -d "$MODULE_BASE/$VENDOR" ]; then
        echo -e "${YELLOW}⚠️  Vendor '$VENDOR' already exists.${NC}"
        read -p "Do you want to continue with this vendor? (y/n): " CONFIRM_VENDOR
        if [[ "$CONFIRM_VENDOR" != "y" && "$CONFIRM_VENDOR" != "Y" ]]; then
            echo -e "${RED}❌ Aborting block creation.${NC}"
            exit 1
        fi
    fi

    read -p "Module Name (e.g. EavManager): " MODULE
    read -p "Block Name (e.g. CustomBlock): " BLOCK

    BLOCK_PATH="$MODULE_BASE/$VENDOR/$MODULE/Block"
    mkdir -p "$BLOCK_PATH"

    NAMESPACE="${VENDOR}\\${MODULE}\\Block"

    # Block PHP file
    cat <<EOF > "$BLOCK_PATH/$BLOCK.php"
<?php
/**
 * @author Ankush Lodhi
 * @package ${VENDOR}_${MODULE}
 */
namespace ${VENDOR}\\${MODULE}\\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class ${BLOCK} extends Template
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected \$scopeConfig;

    /**
     * Constructor
     *
     * @param Context \$context
     * @param array \$data
     */
    public function __construct(
        Context \$context,
        array \$data = []
    ) {
        parent::__construct(\$context, \$data);
        \$this->scopeConfig = \$context->getScopeConfig();
    }

    /**
     * Example method
     *
     * @return string
     */
    public function getWelcomeText()
    {
        return "Hello from ${BLOCK}!";
    }
}

EOF

    echo -e "${GREEN}✅ Block class $BLOCK created at: $BLOCK_PATH/$BLOCK.php${NC}"

    read -p "Do you want to run Magento upgrade commands now? (y/n): " RUN_CMD
    if [[ "$RUN_CMD" == "y" || "$RUN_CMD" == "Y" ]]; then
        run_magento_upgrade
        echo -e "${GREEN}✅ Magento commands executed.${NC}"
    fi
    ;;


  help|*)
    echo -e "${GREEN}Available commands:${NC}"
    echo "  upgrade-dev     : Fast upgrade (no maintenance, dev env)"
    echo "  upgrade-prod    : Full upgrade (maintenance + composer)"
    echo "  clean           : Cache clean & code cleanup"
    echo "  deploy          : Static content deploy"
    echo "  compile         : DI Compile"
    echo "  permissions     : Reset permissions"
    echo "  help            : Show this help message"
    ;;
esac

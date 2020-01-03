<?php
/**
 * Koren Software
 *
 * @package    Koren_SimpleCmsMenu
 * @author     Koren Software
 * @copyright  Copyright (c) 2020 Koren Software. (https://koren.ee)
 * @license    MIT
 */

namespace Koren\SimpleCmsMenu\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Data helper
 */
class Data extends AbstractHelper
{
    const CONFIG_PATH = 'simplecmsmenu/';

    /**
     * Detect if module is enabled
     *
     * @param string $scope Scope
     *
     * @return bool
     */
    public function isEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH.'general/enabled',
            $scope
        );
    }

    /**
     * If menu should be shown only on selected pages
     *
     * @param string $scope Scope
     *
     * @return string
     */
    public function showOnlyOnSelected($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            self::CONFIG_PATH.'general/only_selected',
            $scope
        );
    }
}

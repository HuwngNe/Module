<?php

namespace Ecommage\EcommageVoucher\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper
{
    const XML_PATH_SECTION = 'voucher_setup/';

    /**
     * Get value config
     *
     * @param $field
     * @param $storeId
     * @return mixed
     */
    public function getConfigValue($field, $storeId = null) {
        return $this->scopeConfig->getValue(
            $field, ScopeInterface::SCOPE_STORE, $storeId
        );
    }

    /**
     * @param $code
     * @param $storeId
     * @return mixed
     */
    public function getGeneralConfig($code, $storeId = null) {
        return $this->getConfigValue(self::XML_PATH_SECTION .'voucher_after_sale/'. $code, $storeId);
    }

    /**
     * @param $code
     * @param $storeId
     * @return mixed
     */
    public function getGeneralConfigTemplate($code, $storeId = null) {
        return $this->getConfigValue(self::XML_PATH_SECTION .'template_voucher_send/'. $code, $storeId);
    }

}

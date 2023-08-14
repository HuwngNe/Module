<?php

namespace Ecommage\BuyTogether\Controller\Adminhtml\Pack;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Config\Dom\ValidationException;

class PostDataProcessor
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * Construct
     *
     * @param ManagerInterface $messageManager
     */
    public function __construct(ManagerInterface $messageManager) {
        $this->messageManager = $messageManager;
    }

    /**
     * Validate require field
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'percent' => __('Percent'),
            'title'=> __("Title")
        ];

        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
                return false;
            }
        }
        return true;
    }

    public function checkMainProduct(array $data) {

        if (count($data) == 1) {
            return true;
        }
        $this->messageManager->addErrorMessage(
            __('Main product error')
        );
        return false;
    }

    public function checkBundleProduct(array $data) {
        if (count($data) < 1) {
            $this->messageManager->addErrorMessage(
                __('Product together must require')
            );
        }
        return true;
    }
}

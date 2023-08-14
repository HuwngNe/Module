<?php

namespace Ecommage\FilterStore\Controller\Adminhtml\Location;

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
            'address' => __('Address'),
            'phone' => __('Phone'),
            'email' => __('Email'),
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

}

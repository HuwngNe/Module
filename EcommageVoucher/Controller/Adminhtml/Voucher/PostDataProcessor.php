<?php
namespace Ecommage\EcommageVoucher\Controller\Adminhtml\Voucher;

use Magento\Framework\Message\ManagerInterface;

class PostDataProcessor
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        ManagerInterface $messageManager
    ) {
        $this->messageManager = $messageManager;
    }

    /**
     * Validate form voucher
     *
     * @param array $data
     * @return bool
     */
    public function validateRequireEntry(array $data)
    {
        $requiredFields = [
            'title' => __('Title'),
            'percent' => __('Percent'),
            'start_date'=> __("Start date"),
            'end_date' => __("End date"),
            "status"   =>  __("Status")
        ];
        $errorNo = true;
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $errorNo = false;
                $this->messageManager->addErrorMessage(
                    __('To apply changes you should fill in hidden required "%1" field', $requiredFields[$field])
                );
            }
        }
        return $errorNo;
    }
}

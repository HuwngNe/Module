<?php

namespace Ecommage\EcommageVoucher\Helper;

use Ecommage\EcommageVoucher\Api\VoucherCustomerRepositoryInterface;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\App\Helper\AbstractHelper;
use Ecommage\EcommageVoucher\Helper\Data as DataHelper;
use Magento\Email\Model\TemplateFactory;
use Ecommage\EcommageVoucher\Model\VoucherCustomerFactory;
use Magento\Customer\Model\Session;

class SendMail extends AbstractHelper
{
    /**
     * @var StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var DataHelper
     */
    protected $dataConfig;

    /**
     * @var TemplateFactory
     */
    protected $templateFactory;

    /**
     * @var VoucherCustomerFactory
     */
    protected $voucherCustomerFactory;

    /**
     * @var Session
     */
    protected $sessions;

    /**
     * @var
     */
    private $toEmail;

    /**
     * @var
     */
    private $vars;

    /**
     * @var VoucherCustomerRepositoryInterface
     */
    protected $voucherCustomerRepository;

    /**
     * @param Context $context
     * @param StateInterface $inlineTranslation
     * @param Escaper $escaper
     * @param TransportBuilder $transportBuilder
     * @param Data $dataConfig
     * @param TemplateFactory $templateFactory
     * @param Session $session
     * @param VoucherCustomerFactory $voucherCustomerFactory
     * @param VoucherCustomerRepositoryInterface $voucherCustomerRepository
     */
    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        TransportBuilder $transportBuilder,
        DataHelper $dataConfig,
        TemplateFactory $templateFactory,
        Session $session,
        VoucherCustomerFactory $voucherCustomerFactory,
        VoucherCustomerRepositoryInterface $voucherCustomerRepository
    ) {
        parent::__construct($context);
        $this->sessions = $session;
        $this->voucherCustomerFactory = $voucherCustomerFactory;
        $this->templateFactory = $templateFactory;
        $this->dataConfig = $dataConfig;
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->voucherCustomerRepository = $voucherCustomerRepository;
        $this->logger = $context->getLogger();
    }

    /**
     * Send mail voucher
     *
     * @return void
     */
    public function sendLoadEmail()
    {
        $template = "";

        if ($this->dataConfig->getGeneralConfigTemplate("template_email")) {
            $idTemplate = $this->dataConfig->getGeneralConfigTemplate("template_email");
            if (is_numeric($idTemplate)) {
                $template = $this->templateFactory->create()->load($idTemplate)->getOrigTemplateCode();
            } else {
                $template = 'voucher_setup_template_voucher_send_template_email';
            }
        } else {
            $template = 'voucher_setup_template_voucher_send_template_email';
        }

        $this->saveVoucherCustomer();

        try {
            $this->inlineTranslation->suspend();
            $sender = [
                'name' => $this->escaper->escapeHtml('Thank you'),
                'email' => $this->escaper->escapeHtml('hungmashup98@gmail.com'),
            ];
            $transport = $this->transportBuilder
                ->setTemplateIdentifier($template)
                ->setTemplateOptions(
                    [
                        'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                        'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                    ]
                )
                ->setTemplateVars($this->vars)
                ->setFrom($sender)
                ->addTo($this->toEmail)
                ->getTransport();
            $transport->sendMessage();
            $this->inlineTranslation->resume();

        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }


    }

    /**
     * save voucher customer
     *
     * @return void
     * @throws \Exception
     */
    public function saveVoucherCustomer() {
        $saveVoucher = $this->voucherCustomerFactory->create();
        $valueVoucher = $this->vars;
        $saveVoucher->setVoucherId($valueVoucher["idVoucher"]);
        if ($this->sessions->isLoggedIn()) {
            $saveVoucher->setCustomerId($this->sessions->getCustomerId());
        } else {
            $saveVoucher->setEmail($this->toEmail);
        }
        $saveVoucher->setStatus(1);

        $this->voucherCustomerRepository->save($saveVoucher);
    }

    /**
     * @param $email
     * @return void
     */
    public function setToEmail($email) {
        $this->toEmail = $email;
    }

    /**
     * @return mixed
     */
    public function getToEmail() {
        return $this->toEmail;
    }

    /**
     * @param $val
     * @return void
     */
    public function setVars($val) {
        $this->vars = $val;
    }
}

<?php

namespace Zumento\OrderExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Zumento\OrderExport\Model\HeaderDataFactory;


class Run extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Zumento_OrderExport::OrderExport';

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var HeaderDataFactory
     */
    private $headerDataFactory;

    public function __construct(JsonFactory $jsonFactory,
                                 Context $context,
                                 HeaderDataFactory $headerDataFactory
     ) {
         parent::__construct($context);
         $this->jsonFactory = $jsonFactory;
         $this->headerDataFactory = $headerDataFactory;
    }

    public function execute()
    {
        $headerData = $this->headerDataFactory->create();
        $headerData->setShipDate(new \DateTime($this->getRequest()->getParam("ship_date")));
        $headerData->setMerchantNotes(htmlspecialchars($this->getRequest()->getParam("merchant_notes")));

        return $this->jsonFactory->create([]);
    }
}

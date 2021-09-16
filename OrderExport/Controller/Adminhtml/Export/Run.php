<?php

namespace Zumento\OrderExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;


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

     public function __construct(JsonFactory $jsonFactory, Context $context)
     {
         parent::__construct($context);
         $this->jsonFactory = $jsonFactory;
     }

    public function execute()
    {
        return $this->jsonFactory->create([]);
    }
}

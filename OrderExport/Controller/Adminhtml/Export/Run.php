<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Controller\Adminhtml\Export;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Zumento\OrderExport\Model\HeaderDataFactory;
use Zumento\OrderExport\Orchestrator;


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

    /**
     * @var Orchestrator
     */
    private $orchestrator;

    public function __construct(
        JsonFactory $jsonFactory,
        Context $context,
        Orchestrator $orchestrator,
        HeaderDataFactory $headerDataFactory
     ) {
         $this->jsonFactory = $jsonFactory;
         $this->headerDataFactory = $headerDataFactory;
         $this->orchestrator = $orchestrator;

        parent::__construct($context);
    }

    public function execute()
    {
        $headerData = $this->headerDataFactory->create();
        $headerData->setShipDate(new \DateTime($this->getRequest()->getParam("ship_date")));
        $headerData->setMerchantNotes(htmlspecialchars($this->getRequest()->getParam("merchant_notes")));

        $this->orchestrator->run(
            (int)$this->getRequest()->getParam('order_id'),
            $headerData
        );

        return $this->jsonFactory->create([]);
    }
}

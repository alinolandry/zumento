<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Model\Endpoint;

use Zumento\OrderExport\Api\Data\IncomingHeaderDataInterface;
use Zumento\OrderExport\Api\Data\ResponseDataInterfaceFactory;
use Zumento\OrderExport\Api\ExportInterface;
use Zumento\OrderExport\Orchestrator;
use Zumento\OrderExport\Api\Data\ResponseDataInterface;
use SwiftOtter\OrderExport\Model\ResponseDetailsFactory;

class Export implements ExportInterface
{
    /**
     * @var Orchestrator
     */
    private $orchestrator;

    /**
     * @var ResponseDataInterfaceFactory
     */
    private  $responseFactory;

    /**
     * @param Orchestrator $orchestrator
     * @param ResponseDataInterfaceFactory $responseFactory
     */
    public function __construct(Orchestrator $orchestrator, ResponseDataInterfaceFactory $responseFactory)
    {
        $this->orchestrator = $orchestrator;
        $this->responseFactory = $responseFactory;
    }

    public function execute(int $orderId, IncomingHeaderDataInterface $headerData): ResponseDataInterface
    {
        $details = $this->orchestrator->run(
            $this->getRequest()->getParam('order_id'),
            $headerData->getHeaderData()
        );

        /** ResponseDataInterface $response */
        $response = $this->responseFactory->create();
        $response->setSuccess((bool)$details['success']);
        $response->setError((string)$details['error']);
        return $response;
    }

}

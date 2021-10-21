<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport;

use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use Zumento\OrderExport\Action\PushDetailsToWebservice;
use Zumento\OrderExport\Action\SaveExportDetailsToOrder;
use Zumento\OrderExport\Action\TransformOrderToArray;
use Zumento\OrderExport\Model\HeaderData;
use Zumento\OrderExport\Model\RequestValidator;

class Orchestrator
{
    /**
     * @var TransformOrderToArray
     */
    private $orderToArray;

    /**
     * @var RequestValidator
     */
    private $requestValidator;

    /**
     * @var PushDetailsToWebservice
     */
    private $pushDetailsToWebservice;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var SaveExportDetailsToOrder
     */
    private $saveExportDetailsToOrder;

    /**
     * @param RequestValidator $requestValidator
     * @param TransformOrderToArray $orderToArray
     * @param PushDetailsToWebservice $pushDetailsToWebservice
     * @param SaveExportDetailsToOrder $saveExportDetailsToOrder
     * @param LoggerInterface $logger
     */
    public function __construct(
        RequestValidator $requestValidator,
        TransformOrderToArray $orderToArray,
        PushDetailsToWebservice $pushDetailsToWebservice,
        SaveExportDetailsToOrder $saveExportDetailsToOrder,
        LoggerInterface $logger
    ) {
        $this->orderToArray = $orderToArray;
        $this->requestValidator = $requestValidator;
        $this->pushDetailsToWebservice = $pushDetailsToWebservice;
        $this->logger = $logger;
        $this->saveExportDetailsToOrder = $saveExportDetailsToOrder;
    }
    public function run(int $orderId, HeaderData $headerData): array
    {
        $results = ['success' => false, 'error' => null];

        if (!$this->requestValidator->validate($orderId, $headerData)) {
            $results['error'] = (string)__('Invalid order specified.');
            return $results;
        }


        $orderDetails = $this->orderToArray->execute($orderId, $headerData);

        try {
            $results['success'] = $this->pushDetailsToWebservice->execute($orderId, $orderDetails);
        } catch (NoSuchEntityException $exception) {
            $results['error'] = $exception->getMessage();
            $results['success'] = false;
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage(), [
               'trace' => $exception->getTraceAsString()
            ]);
            $results['error'] = 'A really bad error happened, review the log.';
            $results['success'] = false;
        }

        $this->saveExportDetailsToOrder->execute($orderId, $results, $headerData);

        return $results;
    }

}

<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Webapi\Controller\Rest\RequestValidator;
use Psr\Log\LoggerInterface;
use Zumento\OrderExport\Action\PushDetailsToWebservice;
use Zumento\OrderExport\Action\TransformOrderToArray;
use Zumento\OrderExport\Model\HeaderData;

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
     * @param RequestValidator $requestValidator
     * @param TransformOrderToArray $orderToArray
     * @param PushDetailsToWebservice $pushDetailsToWebservice
     * @param LoggerInterface $logger
     */
    public function __construct(
        RequestValidator $requestValidator,
        TransformOrderToArray $orderToArray,
        PushDetailsToWebservice $pushDetailsToWebservice,
        LoggerInterface $logger
    ) {
        $this->orderToArray = $orderToArray;
        $this->requestValidator = $requestValidator;
        $this->pushDetailsToWebservice = $pushDetailsToWebservice;
        $this->logger = $logger;
    }
    public function run(int $orderId, HeaderData $headerData): array
    {
        $results = ['success' => false, 'error' => null];

        if (!$this->requestValidator->isValid($orderId)) {
            $results['error'] = (string)__('The order ID provided was invalid');
            return $results;
        }


        $orderDetails = $this->orderToArray->execute($orderId, $headerData);

        try {
            $this->pushDetailsToWebservice->execute($orderId, $orderDetails);
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

        return $results;
    }

}

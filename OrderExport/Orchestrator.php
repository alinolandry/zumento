<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport;

use Zumento\OrderExport\Action\TransformOrderToArray;
use Zumento\OrderExport\Model\HeaderData;

class Orchestrator
{

    /**
     * @var TransformOrderToArray
     */
    private $orderToArray;

    /**
     * @param TransformOrderToArray $orderToArray
     */
    public function __construct(TransformOrderToArray $orderToArray)
    {
        $this->orderToArray = $orderToArray;
    }
    public function run(int $orderId, HeaderData $headerData): array
    {
        $results = ['success' => false, 'error' => null];
        $orderDetails = $this->orderToArray->execute($orderId, $headerData);

        return $results;
    }

}

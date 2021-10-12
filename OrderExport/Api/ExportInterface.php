<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Api;

use Zumento\OrderExport\Api\Data\IncomingHeaderDataInterface;
use Zumento\OrderExport\Api\Data\ResponseDataInterface;

interface ExportInterface
{
    /**
     * @param int $orderId
     * @param IncomingHeaderDataInterface $incomingHeaderData
     * @return ResponseDataInterface
     */
    public function execute(int $orderId, IncomingHeaderDataInterface $incomingHeaderData): ResponseDataInterface;

}

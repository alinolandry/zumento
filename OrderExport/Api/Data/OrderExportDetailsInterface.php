<?php
declare(strict_types=1);
/**
 * @by Alain Landry Noutchomwo
 * @alias Zumento
 */

namespace Zumento\OrderExport\Api\Data;

/**
 *
 */
interface OrderExportDetailsInterface
{
    /**
     * @return int
     */
    public function getOrderId(): int;

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void;

    /**
     * @return \DateTime
     */
    public function getShipOn(): \DateTime;

    /**
     * @param \DateTime $shipOn
     */
    public function setShipOn(\DateTime $shipOn): void;

    /**
     * @return \DateTime
     */
    public function getExportedAt(): \DateTime;

    /**
     * @param \DateTime $exportedAt
     */
    public function setExportedAt(\DateTime $exportedAt): void;

    /**
     * @return bool
     */
    public function hasBeenExported(): bool;

    /**
     * @return string
     */
    public function getMerchantNotes(): string;

    /**
     * @param string $merchantNotes
     */
    public function setMerchantNotes(string $merchantNotes): void;

}

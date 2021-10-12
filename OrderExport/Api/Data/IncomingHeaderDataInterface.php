<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Api\Data;

use Zumento\OrderExport\Model\HeaderData;

interface IncomingHeaderDataInterface
{
    /**
     * @return string
     */
    public function getShipDate(): string;

    /**
     * @param string $shipDate
     */
    public function setShipDate(string $shipDate): void;

    /**
     * @return string
     */
    public function getMerchantNotes(): string;

    /**
     * @param string $merchantNotes
     */
    public function setMerchantNotes(string $merchantNotes): void;

    /**
     * @return HeaderData
     */
    public function getHeaderData(): HeaderData;
}

<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Model;

use Zumento\OrderExport\Api\Data\IncomingHeaderDataInterface;

class IncomingHeaderData implements IncomingHeaderDataInterface
{
    private $shipdate;

    private $merchantNotes;
    /**
     * @var HeaderDataFactory
     */
    private $headerDataFactory;

    /**
     * @param HeaderDataFactory $headerDataFactory
     */
    public function __construct(HeaderDataFactory $headerDataFactory)
    {

        $this->headerDataFactory = $headerDataFactory;
    }

    public function getShipDate(): string
    {
       return (string)$this->getShipDate;
    }

    /**
     * @param string $shipDate
     */
    public function setShipDate(string $shipDate): void
    {
        $this->shipdate = $shipDate;
    }

    /**
     * @return string
     */
    public function getMerchantNotes(): string
    {
        return (string)$this->merchantNotes;
    }

    /**
     * @param string $merchantNotes
     */
    public function setMerchantNotes(string $merchantNotes): void
    {
        $this->merchantNotes = $merchantNotes;
    }

    /**
     * @return HeaderData
     */
    public function getHeaderData(): HeaderData
    {
        $headerData = $this->headerDataFactory->create();
        $headerData->setShipDate(new \DateTime($this->getShipDate()));
        $headerData->setMerchantNotes($this->getMerchantNotes());

        return $headerData;
    }
}

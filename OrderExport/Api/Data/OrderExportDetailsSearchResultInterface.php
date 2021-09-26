<?php
declare(strict_types=1);
/**
 * @by Alain Landry Noutchomwo
 * @alias Zumento
 */

namespace Zumento\OrderExport\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface OrderExportDetailsSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Zumento\OrderExport\Api\Data\OrderExportDetailsInterface[]
     */
    public function getItems();

    /**
     * @param \Zumento\OrderExport\Api\Data\OrderExportDetailsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

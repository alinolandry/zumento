<?php

namespace Zumento\GiftCard\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;


interface GiftCardSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get GiftCard list.
     *
     * @return \Zumento\GiftCard\Api\Data\GiftCardInterface[]
     */
    public function getItems();

    /**
     * Set GiftCard list.
     *
     * @param \Zumento\GiftCard\Api\Data\GiftCardInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

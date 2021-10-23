<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Model\ResourceModel\GiftCardUsage;


use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zumento\GiftCard\Model\GiftCardUsage as GiftCardUsageModel;
use Zumento\GiftCard\Model\ResourceModel\GiftCardUsage as GiftCardUsageResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Initialization here
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GiftCardUsageModel::class, GiftCardUsageResourceModel::class);
    }

}

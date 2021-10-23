<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Model\ResourceModel\GiftCard;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Zumento\GiftCard\Model\GiftCard as GiftCardModel;
use Zumento\GiftCard\Model\ResourceModel\GiftCard as GiftCardResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Initialization here
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GiftCardModel::class, GiftCardResourceModel::class);
    }

}

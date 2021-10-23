<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Model;

use Magento\Framework\Model\AbstractModel;
use Zumento\GiftCard\Api\Data\GiftCardUsageInterface;
use Zumento\GiftCard\Model\ResourceModel\GiftCardUsage as GiftCardUsageResourceModel;

class GiftCardUsage extends AbstractModel implements GiftCardUsageInterface
{
    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GiftCardUsageResourceModel::class);
    }

    /**
     * @return int
     */
    public function getGiftCardId(): int
    {
        return (int)$this->getData('gift_card_id');
    }

    /**
     * @param int $value
     * @return void
     */
    public function setGiftCardId(int $value): void
    {
        $this->setData('gift_card_id', $value);
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return (int)$this->getData('order_id');
    }

    /**
     * @param int $value
     * @return void
     */
    public function setOrderId(int $value): void
    {
        $this->setData('order_id', $value);
    }

    /**
     * @return float
     */
    public function getValueChange(): float
    {
        return (float)$this->getData('value_change');
    }

    /**
     * @param float $value
     * @return void
     */
    public function setValueChange(float $value): void
    {
        $this->setData('value_change', $value);
    }

    /**
     * @return string
     */
    public function getNotes(): string
    {
        return (string)$this->getData('notes');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setNotes(string $value): void
    {
        $this->setData('notes', $value);
    }

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): \DateTime
    {
        return new \DateTime($this->getData('created_at'));
    }

    /**
     * @param \DateTime $value
     */
    public function setCreatedAt(\DateTime $value): void
    {
        $this->setData('created_at', $value->format('Y-m-d h:i:s'));
    }

}

<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Model;

use Magento\Framework\Model\AbstractModel;
use Zumento\GiftCard\Api\Data\GiftCardInterface;
use Zumento\GiftCard\Model\ResourceModel\GiftCard as GiftCardResourceModel;

/**
 *
 */
class GiftCard extends AbstractModel implements GiftCardInterface
{
    /**
     * Model construct that should be used for object initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GiftCardResourceModel::class);
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return (int)$this->getData('assigned_customer_id');
    }

    /**
     * @param int $value
     */
    public function setCustomerId(int $value): void
    {
        $this->setData('assigned_customer_id', $value);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return (string)$this->getData('code');
    }

    /**
     * @param string $value
     */
    public function setCode(string $value): void
    {
        $this->setData('code', $value);
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return (int)$this->getData('status');
    }

    /**
     * @param int $value
     */
    public function setStatus(int $value): void
    {
        $this->setData('status', $value);
    }

    /**
     * @return float
     */
    public function getInitialValue(): float
    {
        return (float)$this->getData('initial_value');
    }

    /**
     * @param float $value
     */
    public function setInitialValue(float $value): void
    {
        $this->setData('initial_value', $value);
    }

    /**
     * @return float
     */
    public function getCurrentValue(): float
    {
        return (float)$this->getData('current_value');
    }

    /**
     * @param float $value
     */
    public function setCurrentValue(float $value): void
    {
        $this->setData('current_value', $value);
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

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getUpdateAt(): \DateTime
    {
        return new \DateTime($this->getData('updated_at'));
    }

    /**
     * @param \DateTime $value
     */
    public function setUpdateAt(\DateTime $value): void
    {
        $this->setData('updated_at', $value->format('Y-m-d h:i:s'));
    }

    /**
     * @return string
     */
    public function getRecipientEmail(): string
    {
        return (string)$this->getData('recipient_email');
    }

    /**
     * @param string $value
     */
    public function setRecipientEmail(string $value): void
    {
        $this->setData('recipient_email', $value);
    }

    /**
     * @return string
     */
    public function getRecipientName(): string
    {
        return (string)$this->getData('recipient_name');
    }

    /**
     * @param string $value
     */
    public function setRecipientName(string $value): void
    {
        $this->setData('recipient_name', $value);
    }
}

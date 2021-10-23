<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Api\Data;

interface GiftCardUsageInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @param $id
     * @return void
     */
    public function setId($id);

    /**
     * @return int
     */
    public function getGiftCardId(): int;

    /**
     * @param int $value
     * @return void
     */
    public function setGiftCardId(int $value): void;

    /**
     * @return int
     */
    public function getOrderId(): int;

    /**
     * @param int $value
     * @return void
     */
    public function setOrderId(int $value): void;

    /**
     * @return float
     */
    public function getValueChange(): float;

    /**
     * @param float $value
     * @return void
     */
    public function setValueChange(float $value): void;

    /**
     * @return string
     */
    public function getNotes(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setNotes(string $value): void;

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $value
     */
    public function setCreatedAt(\DateTime $value): void;
}

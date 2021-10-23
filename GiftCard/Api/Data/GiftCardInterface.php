<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\GiftCard\Api\Data;

interface GiftCardInterface
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
    public function getCustomerId(): int;

    /**
     * @param int $value
     * @return void
     */
    public function setCustomerId(int $value): void;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setCode(string $value): void;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $value
     * @return void
     */
    public function setStatus(int $value): void;

    /**
     * @return float
     */
    public function getInitialValue(): float;

    /**
     * @param float $value
     * @return void
     */
    public function setInitialValue(float $value): void;

    /**
     * @return float
     */
    public function getCurrentValue(): float;

    /**
     * @param float $value
     * @return void
     */
    public function setCurrentValue(float $value): void;

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getCreatedAt(): \DateTime;

    /**
     * @param \DateTime $value
     * @return void
     */
    public function setCreatedAt(\DateTime $value): void;

    /**
     * @return \DateTime
     * @throws \Exception
     */
    public function getUpdateAt(): \DateTime;

    /**
     * @param \DateTime $value
     * @return void
     */
    public function setUpdateAt(\DateTime $value): void;

    /**
     * @return string
     */
    public function getRecipientEmail(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setRecipientEmail(string $value): void;

    /**
     * @return string
     */
    public function getRecipientName(): string;

    /**
     * @param string $value
     * @return void
     */
    public function setRecipientName(string $value): void;
}

<?php
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 *
 */
namespace Zumento\OrderExport\Api\Data;

interface ResponseDataInterface
{
    /**
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * @param bool $success
     * @return void
     */
    public function setSuccess(bool $success): void;

    /**
     * @return string
     */
    public function getError(): string;

    /**
     * @param string $error
     * @return void
     */
    public function setError(string $error): void;
}

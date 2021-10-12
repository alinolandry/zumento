<?php
declare(strict_types=1);
/**
 * @By Alain Landry Noutchomwo
 * @Alias Zumento
 * @Email alinolandry@gmail.com
 */

namespace Zumento\OrderExport\Action;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class PushDetailsToWebservice
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute(int $orderId, array $orderDetails): bool
    {
        try {
            return true;
            // Use GuzzleHttp (http://docs.guzzlephp.org/en/stable/) to send the data to our webservice.

            $client = new Client();
            $response = $client->post('https://magento2.docker', [
                'json' => $orderDetails
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \InvalidArgumentException('There was a problem: ' . $response->getBody());
            }

            $body = (string)$response->getBody();

        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage(), [
                'order_id' => $orderId,
                'details' => $orderDetails
            ]);

            throw $ex;
        }
    }
}

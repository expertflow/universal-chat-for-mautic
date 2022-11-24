<?php
/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * 
 */

namespace MauticPlugin\MauticActivemqTransportBundle\Exception;

/**
 * Class ActivemqServerException.
 */
class ActivemqServerException extends ActivemqPluginException
{
    /**
     * @var null|string
     */
    private $payload;

    /**
     * ActivemqServerException constructor.
     *
     * @param string      $xmlResponse
     * @param int         $httpCode
     * @param null|string $payload
     */
    public function __construct(string $xmlResponse, int $httpCode, string $payload = null)
    {
        $this->payload = $payload;

        $message = sprintf('%s (%d)', $xmlResponse, $httpCode);

        parent::__construct($message, $httpCode);
    }

    /**
     * @return string|null
     */
    public function getPayload()
    {
        return $this->payload;
    }
}

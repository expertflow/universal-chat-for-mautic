<?php

declare(strict_types=1);

/*
 * @copyright   2018 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticActivemqTransportBundle\Transport;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Mautic\LeadBundle\Entity\Lead;
use Mautic\LeadBundle\Model\LeadModel;
use Mautic\LeadBundle\Model\DoNotContact;
use Mautic\IntegrationsBundle\Exception\PluginNotConfiguredException;
use Mautic\IntegrationsBundle\Helper\IntegrationsHelper;
use Mautic\SmsBundle\Sms\TransportInterface;
use MauticPlugin\MauticActivemqTransportBundle\Exception\InvalidRecipientException;
use MauticPlugin\MauticActivemqTransportBundle\Exception\MessageException;
use MauticPlugin\MauticActivemqTransportBundle\Exception\ActivemqPluginException;
use MauticPlugin\MauticActivemqTransportBundle\Exception\ActivemqServerException;
use MauticPlugin\MauticActivemqTransportBundle\Integration\ActivemqIntegration;
use Monolog\Logger;

use Stomp\Client;
use Stomp\SimpleStomp;
use Stomp\Transport\Map;

/**
 * Class ActivemqTransport is the transport service for mautic.
 */
class ActivemqTransport implements TransportInterface
{
    /**
     * @var Connector
     */
    private $connector;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var string
     */
    private $keywordField;

    /**
     * @var DoNotContact
     */
    private $doNotContactService;

    /**
     * @var IntegrationsHelper
     */
    private $integrationsHelper;

    /**
     * @var bool
     */
    private $connectorConfigured = false;

    /**
     * ActivemqTransport constructor.
     *
     * @param IntegrationsHelper $integrationsHelper
     * @param Logger            $logger
     * @param Connector         $connector
     * @param MessageFactory    $messageFactory
     * @param DoNotContact      $doNotContactService
     */
    public function __construct(
        IntegrationsHelper $integrationsHelper,
        Logger $logger,
        DoNotContact $doNotContactService
    ) {
        $this->logger              = $logger;
        $this->doNotContactService = $doNotContactService;
        $this->integrationsHelper  = $integrationsHelper;
    }

    /**
     * @param Lead   $contact
     * @param string $content
     *
     * @return bool|PluginNotConfiguredException|mixed|string
     * @throws MessageException
     * @throws SloocePluginException
     * @throws \Mautic\IntegrationsBundle\Exception\IntegrationNotFoundException
     */
    public function sendSms(Lead $lead, $content)
    {
        $number = $lead->getLeadPhoneNumber();
        $lead_id = $lead->getId();
           
        // make a connection
        $client = new Client('tcp://173.212.195.56:61613');
        $stomp = new SimpleStomp($client);

        // send a message to the queue
        $body = array(
            'conversationId'=>'conversation_'.$lead_id,
            'messageId'=>'message_'.$lead_id,
            'messageType'=> 'ChatMessage',
            'from' => [
                'id'=>'14322397378',
                'name'=>'Expertflow Admin',
                'firstName'=>'Expertflow',
                'lastName'=>'Admin',
                'type' => 'Agent'
            ],
            'to'=> $number,
            'timestamp'=> Date('Y-m-d H:i:s'),
            'tag'=> '',
            'refId'=> $number,
            'processByBot'=> false,
            'language'=> 'en',
            'channel'=> 'sms',
            'text'=> $content,
            'attachments'=> [],
            'buttons'=> [],
            'botResponseType'=> 'simple'
        );
        $headers = array('type' => 'SendSms','persistent' => 'true');
 
        $client->send('/queue/sms', json_encode($body), $headers);

        return true;
    }

}

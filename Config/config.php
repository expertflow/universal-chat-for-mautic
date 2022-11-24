<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

return [
    'name'        => 'Activemq',
    'description' => 'Enables ActiveMQ Integrations Transport',
    'version'     => '2.0',
    'author'      => 'Mautic',
    'services'    => [
        'events'       => [
        ],
        'forms'        => [
            'mautic.activemq.form.config_auth' => [
                'class' => \MauticPlugin\MauticActivemqTransportBundle\Form\Type\ConfigAuthType::class,
                'arguments' => [
                    'mautic.lead.model.field',
                ],
            ],
        ],

        'other'        => [
            'mautic.sms.transport.activemq' => [
                'class'        => \MauticPlugin\MauticActivemqTransportBundle\Transport\ActivemqTransport::class,
                'arguments'    => [
                    'mautic.integrations.helper',
                    'monolog.logger.mautic',
                    'mautic.lead.model.dnc',
                ],
                'tag'          => 'mautic.sms_transport',
                'tagArguments' => [
                    'integrationAlias' => 'Activemq',
                ],
            ],
        ],
        'models'       => [
        ],
        'integrations' => [
            'mautic.integration.activemq' => [
                'class'     => \MauticPlugin\MauticActivemqTransportBundle\Integration\ActivemqIntegration::class,
                'arguments' => [
                ],
                'tags'      => [
                    'mautic.integration',
                    'mautic.basic_integration',
                    'mautic.config_integration',
                    'mautic.auth_integration',
                ],
            ],
        ],
    ],
    'routes'      => [
        'main'   => [
        ],
        'public' => [
        ],
        'api'    => [
        ],
    ],
    'menu'        => [
        'main' => [
            'items' => [
                'mautic.sms.smses' => [
                    'route'    => 'mautic_sms_index',
                    'access'   => ['sms:smses:viewown', 'sms:smses:viewother'],
                    'parent'   => 'mautic.core.channels',
                    'checks'   => [
                        'integration' => [
                            'Activemq' => [
                                'enabled' => true,
                            ],
                        ],
                    ],
                    'priority' => 70,
                ],
            ],
        ],
    ],
    'parameters'  => [
    ],
];

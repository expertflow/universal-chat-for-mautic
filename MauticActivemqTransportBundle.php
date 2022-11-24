<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticActivemqTransportBundle;

use Mautic\PluginBundle\Bundle\PluginBundleBase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class MauticActivemqTransportBundle.
 */
class MauticActivemqTransportBundle extends PluginBundleBase
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}

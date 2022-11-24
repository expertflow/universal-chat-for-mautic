<?php

declare(strict_types=1);

/*
 * @copyright   2018 Mautic Inc. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://www.mautic.com
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace MauticPlugin\MauticActivemqTransportBundle\Form\Type;

use Mautic\IntegrationsBundle\Form\Type\Auth\BasicAuthKeysTrait;
use Mautic\LeadBundle\Model\FieldModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConfigAuthType extends AbstractType
{
    use BasicAuthKeysTrait;

    /**
     * @var FieldModel
     */
    private $fieldModel;

    /**
     * ConfigAuthType constructor.
     *
     * @param FieldModel $fieldModel
     */
    public function __construct(FieldModel $fieldModel)
    {
        $this->fieldModel = $fieldModel;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
      
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'integration' => null,
        ]);
    }
}

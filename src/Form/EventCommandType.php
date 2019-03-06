<?php

namespace AppBundle\Form;

use AppBundle\Event\EventCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;

class EventCommandType extends AbstractType
{
    public function getParent(): string
    {
        return BaseEventCommandType::class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EventGroupCategoryType::class, [
                'class' => $options['event_category_class'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefaults([
                'data_class' => EventCommand::class,
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'committee_event';
    }
}

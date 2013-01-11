<?php

namespace ServerGrove\KbBundle\Form;

use ServerGrove\KbBundle\Util\Sluggable;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * Class ArticleEditType
 *
 * @author Ismael Ambrosi<ismael@servergrove.com>
 */
class ArticleEditType extends ArticleType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug', 'text', array('label' => 'Url identifier'));
        $builder->get('slug')->addEventListener(
            FormEvents::BIND,
            function (FormEvent $event) {
                $event->setData(Sluggable::urlize($event->getData()));
            }
        );

        parent::buildForm($builder, $options);
    }
}

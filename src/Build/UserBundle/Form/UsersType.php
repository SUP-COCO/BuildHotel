<?php

namespace Build\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('username')
            ->add('password')
            ->add('mail')
            // ->add('authTicket')
            // ->add('rank')
            // ->add('credits')
            // ->add('vipPoints')
            // ->add('activityPoints')
            // ->add('activityPointsLastupdate')
            // ->add('look')
            // ->add('gender')
            ->add('motto')
            // ->add('accountCreated')
            // ->add('lastOnline')
            // ->add('online')
            // ->add('ipLast')
            // ->add('ipReg')
            // ->add('homeRoom')
            // ->add('newbieStatus')
            // ->add('isMuted')
            // ->add('blockNewfriends')
            // ->add('hideOnline')
            // ->add('hideInroom')
            // ->add('mailVerified')
            // ->add('vip')
            // ->add('volume')
            // ->add('acceptTrading')
            // ->add('jetons')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Build\UserBundle\Entity\Users'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'build_userbundle_users';
    }
}

<?php

namespace FinanceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\GoogleMapBundle\Form\Type\PlacesAutocompleteType;

class StockType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('ticker', 'text', array(
//                'label' => 'ticker',
//                'data' => 'type ticker information'))
            ->add('ticker')
            ->add('numShares')
            ->add('location', PlacesAutocompleteType::class)
           // ->add('user')
        ;


//        $builder->add('field', PlaceAutocompleteType::class, [
//            'variable' => 'place_autocomplete',
//        ]);

    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FinanceBundle\Entity\Stock'
        ));
    }
}

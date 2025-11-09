<?php
namespace App\Form;

use App\Entity\Smartphone;
use App\Entity\Vendor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SmartphoneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Smartphone naam', 'required' => false])
            ->add('vendor', EntityType::class, [
                'class' => Vendor::class,
                'choice_label' => 'name',
                'label' => 'Vendor',
                'placeholder' => 'Kies een vendor',
                'required' => false,
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Kleur',
                'choices' => [
                    'Zwart' => 'black',
                    'Wit' => 'white',
                    'Blauw' => 'blue',
                    'Rood' => 'red',
                    'Groen' => 'green',
                ],
                'placeholder' => 'Kies een kleur',
                'required' => false,
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prijs',
                'required' => false,
                'currency' => 'EUR',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Smartphone::class]);
    }
}

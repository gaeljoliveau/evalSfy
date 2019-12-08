<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Category;
use App\EventSubscriber\Form\ArtworkFormSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Count;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "Le nom est obligatoire"
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => "La description est obligatoire"
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                /*
                 * EntityType : champ de formulaire relié à une entité
                 *  - class : entité en relation
                 *  - choice_label : choix d'une propriété de l'entité à afficher
                 *  - multiple : sélection de plusieurs choix; par défaut false
                 *  - expanded : affichage de plusieurs champs; par défaut false
                 *      multiple : false > expanded : false = select
                 *      multiple : false > expanded : true = boutons radio
                 *      multiple : true > expanded : true = cases à cocher
                 *      multiple : true > expanded : false = menu
                 *  - contraintes pour les cases à cocher
                 *      Count: comptage du nombre de sélection
                 */
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
            ])
        ;

        $builder->addEventSubscriber(new ArtworkFormSubscriber());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}

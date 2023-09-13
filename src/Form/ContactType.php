<?php

namespace App\Form;

use App\Entity\Assistantes;
use App\Entity\Contact;
use App\Entity\Filiales;
use App\Repository\AssistantesRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('Assistante', EntityType::class, [
                'class' => Assistantes::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.Nom', 'ASC')
                        ->andWhere('u.isActive = 1');

                },
            ])
            ->add('Civilite', ChoiceType::class, [
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                    'Mademoiselle' => 'Mademoiselle',
                    'Madame, Monsieur' => 'Madame, Monsieur',
                    'Société' => 'Société',
                ]
            ])
            ->add('Nom')
            ->add('Adresse')
            ->add('CodePostal')
            ->add('Ville')
            ->add('Telephone')
            ->add('Email')
            ->add('Type', ChoiceType::class, [
                'choices' => [
                    'PRIVE' => 'Expertise privée',
                    'JUD' => 'Expertise judiciaire',
                    'AR' => 'Assistance à réception',
                    'EVAL' => 'Evaluation',
                    'DTG' => 'Diagnostic technique global'
                ]
            ])
            ->add('MotifContact', TextareaType::class, [
                'attr' => [
                    'rows' => 2]])
            ->add('AdresseExpertise')
            ->add('Origine', ChoiceType::class, [
                'choices' => [
                    'Site internet' => 'Site internet',
                    'Recommandation' => 'Recommandation',
                    'BNI' => 'BNI',
                    'Google' => 'Google',
                    'Pages jaunes' => 'Pages jaunes',
                    'Facebook' => 'Facebook',
                    'Instagram' => 'Instagram',
                    'Linkedin' => 'Linkedin',
                    'Chatbot' => 'Chatbot',
                    'Commercial' => 'Commercial',
                    'Campagne emailing' => 'Campagne emailing',
                ]
            ])
            ->add('Intermediaire')
            ->add('Notes')
            ->add('Suites')
            ->add('Statut', ChoiceType::class, [
               'choices' => [
                   'En cours' => 'En cours',
                   'Devis signé' => 'Devis signé',
                   'Annulé' => 'Annulé',
                   'Pas de retour expert' => 'Pas de retour expert',
                   'Pas de retour client' => 'Pas de retour client'
               ]
            ])
            ->add('Filiale', EntityType::class, [
                'class' => Filiales::class
            ])
            ->add('Prospects', EntityType::class, [
                'class' => Filiales::class
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}

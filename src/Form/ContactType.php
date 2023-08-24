<?php

namespace App\Form;

use App\Entity\Assistantes;
use App\Entity\Contact;
use App\Entity\Filiales;
use Doctrine\ORM\Mapping\Entity;
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
                'class' => Assistantes::class
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
                    'Expertise privée' => 'Expertise privée',
                    'Expertise judiciaire' => 'Expertise judiciaire',
                    'Assistance à réception' => 'Assistance à réception',
                    'Catastrophe naturelle' => 'Catastrophe naturelle',
                    'Expertise assuré' => 'Expertise assuré',
                    'Expertise avant achat' => 'Expertise avant achat',
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

<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class, array('attr' => array('placeholder' => 'Your email address (required)'),
				'constraints' => array(
					new NotBlank(array("message" => "Please provide a valid email")),
					new Email(array("message" => "Your email doesn't seems to be valid")),
				)
			))
			->add('subject', TextType::class, array(
				'attr' => array('placeholder' => 'Subject'),
				'required' => false,
				'constraints' => array()
			))
			->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Your message here (required)'),
				'constraints' => array(
					new NotBlank(array("message" => "Please provide a message here")),
				)
			));
	}

	public function setDefaultOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults(array(
			'error_bubbling' => true
		));
	}

	public function getName()
	{
		return 'contact_form';
	}
}
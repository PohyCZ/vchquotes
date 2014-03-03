<?php

namespace Pohy\QuoteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('username', 'text');
		$builder->add('password', 'repeated', array(
			'first_name' 	=> 'first',
			'second_name' 	=> 'second',
			'type'			=> 'password',
			'invalid_message' => 'Passwords have to match'
		));
		$builder->add('submit', 'submit');
	}

	public function setDefautlOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Pohy\QuoteBundle\Entity\User'
		));
	}

	public function getName()
	{
		return 'user';
	}
}
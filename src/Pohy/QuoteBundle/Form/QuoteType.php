<?php

namespace Pohy\QuoteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('text', 'textarea');
		$builder->add('submit', 'submit');
	}

	public function setDefautlOptions(OptionsResolverInterface $resolver)
	{
		$resolver->setDefaults(array(
			'data_class' => 'Pohy\QuoteBundle\Entity\Quote'
		));
	}

	public function getName()
	{
		return 'quote';
	}
}
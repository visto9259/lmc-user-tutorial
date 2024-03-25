<?php

namespace User\Form;

use Laminas\Filter\StringTrim;
use Laminas\Form\Element\Text;
use Laminas\Form\Form;
use Laminas\InputFilter\Input;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;
use Psr\Container\ContainerInterface;

class RegisterFormDelegatorFactory implements DelegatorFactoryInterface
{

    public function __invoke(ContainerInterface $container, $name, callable $callback, ?array $options = null)
    {
        // First, create the form instance
        /** @var Form $form */
        $form = call_user_func($callback, $options);

        // Add the tagline element. The name of the element must match the property in User entity
        $form->add([
            'name' => 'tagline',
            'type' => Text::class,
            'options' => [
                'label' => 'Tagline',
            ],
        ]);

        // We could get fancy and add filtering and validation if we wanted to
        return $form;
    }
}

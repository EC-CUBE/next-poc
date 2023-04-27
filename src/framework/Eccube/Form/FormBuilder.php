<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Eccube\Form;

use Eccube\Validator\Constraint;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

class FormBuilder
{

    private FormBuilderInterface $adaptee;

    public function __construct(FormBuilderInterface $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function setMethod($method)
    {
        $this->adaptee->setMethod($method);
        return $this;
    }

    public function getForm(): Form
    {
        return new Form($this->adaptee->getForm());
    }

    public function add($child, string $type = null, array $options = [])
    {
        if (isset($options['constraints'])) {
            if (is_array($options['constraints'])) {
                $options['constraints'] = array_map(function ($c) {
                    return $c instanceof Constraint ? $c->getConstraint() : $c;
                }, $options['constraints']);
            } elseif ($options['constraints'] instanceof Constraint) {
                $options['constraints'] = $options['constraints']->getConstraint();
            }
        }
        if ($child instanceof FormBuilder) {
            $this->adaptee->add($child->adaptee, $type, $options);
        } else {
            $this->adaptee->add($child, $type, $options);
        }
        return $this;
    }

    public function get(string $name): FormBuilder
    {
        return new FormBuilder($this->adaptee->get($name));
    }

    public function setData($data)
    {
        $this->adaptee->setData($data);
        return $this;
    }

    /**
     * TODO 削除
     * @param string $eventName
     * @param callable $listener
     * @param int $priority
     * @return $this
     */
    public function addEventListener(string $eventName, callable $listener, int $priority = 0): self
    {
        $this->adaptee->addEventListener($eventName, $listener, $priority);
        return $this;
    }

    public function addEventSubscriber(EventSubscriberInterface $subscriber): self
    {
        $this->adaptee->addEventSubscriber($subscriber);
        return $this;
    }

    public function onPreSetData(callable $listener, int $priority = 0): self
    {
        $this->adaptee->addEventListener(FormEvents::PRE_SET_DATA, $this->wrapEventListener($listener), $priority);
        return $this;
    }

    public function onPostSubmit(callable $listener, int $priority = 0): self
    {
        $this->adaptee->addEventListener(FormEvents::POST_SUBMIT, $this->wrapEventListener($listener), $priority);
        return $this;
    }

    private function wrapEventListener(callable $listener): callable
    {
        return function (\Symfony\Component\Form\FormEvent $formEvent) use ($listener) {
            $listener(new FormEvent($formEvent));
        };
    }

    public function remove(string $name): self
    {
        $this->adaptee->remove($name);
        return $this;
    }

    public function getName(): string
    {
        return $this->adaptee->getName();
    }

    public function setAttribute(string $name, $value): self
    {
        $this->adaptee->setAttribute($name, $value);
        return $this;
    }

    public function create(string $name, string $type = null, array $options = []): self
    {
        return new FormBuilder($this->adaptee->create($name, $type, $options));
    }

    /**
     * TODO DataTransformerInterface
     */
    public function addModelTransformer(DataTransformerInterface $modelTransformer, bool $forceAppend = false): self
    {
        $this->adaptee->addModelTransformer($modelTransformer, $forceAppend);
        return $this;
    }

}

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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;

class FormBuilder
{

    private FormBuilderInterface $formBuilder;

    public function __construct(FormBuilderInterface $formBuilder)
    {
        $this->formBuilder = $formBuilder;
    }

    public function setMethod($method)
    {
        $this->formBuilder->setMethod($method);
        return $this;
    }

    public function getForm(): Form
    {
        return new Form($this->formBuilder->getForm());
    }

    public function add($child, string $type = null, array $options = [])
    {
        $this->formBuilder->add($child, $type, $options);
        return $this;
    }

    public function get(string $name): FormBuilder
    {
        return new FormBuilder($this->formBuilder->get($name));
    }

    public function setData($data)
    {
        $this->formBuilder->setData($data);
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
        $this->formBuilder->addEventListener($eventName, $listener, $priority);
        return $this;
    }

    public function addEventSubscriber(EventSubscriberInterface $subscriber): self
    {
        $this->formBuilder->addEventSubscriber($subscriber);
        return $this;
    }

    public function onPreSetData(callable $listener, int $priority = 0): self
    {
        $this->formBuilder->addEventListener(FormEvents::PRE_SET_DATA, $this->wrapEventListener($listener), $priority);
        return $this;
    }

    public function onPostSubmit(callable $listener, int $priority = 0): self
    {
        $this->formBuilder->addEventListener(FormEvents::POST_SUBMIT, $this->wrapEventListener($listener), $priority);
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
        $this->formBuilder->remove($name);
        return $this;
    }

    public function getName(): string
    {
        return $this->formBuilder->getName();
    }

    public function setAttribute(string $name, $value): self
    {
        $this->formBuilder->setAttribute($name, $value);
        return $this;
    }
}

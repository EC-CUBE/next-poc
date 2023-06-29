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

namespace Eccube\Form\Type;

use Eccube\Http\File\FileInterface;
use Symfony\Component\Form\Event\SubmitEvent;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileType extends \Symfony\Component\Form\Extension\Core\Type\FileType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        $builder->addEventListener(FormEvents::SUBMIT, function (SubmitEvent $event) {
            $data = $event->getData();
            if (is_array($data)) {
                $data = array_map(function ($d) {
                    return $this->convertFile($d);
                }, $data);
            }
            if ($data instanceof File) {
                $data = $this->convertFile($data);
            }
            $event->setData($data);
            $event->getForm()->setData($data);
        });
    }

    private function convertFile(mixed $data)
    {
        if ($data instanceof UploadedFile) {
            return new \Eccube\Http\File\UploadedFile($data);
        } else if ($data instanceof File) {
            return new \Eccube\Http\File\File($data);
        }
        return $data;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', function (Options $options) {
            return $options['multiple'] ? null : FileInterface::class;
        });
    }

}

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

namespace Eccube\Http;

use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    private HttpFoundationRequestHandler $adaptee;

    public function __construct(HttpFoundationRequestHandler $adaptee)
    {
        $this->adaptee = $adaptee;
    }

    public function handleRequest(FormInterface $form, $request = null): void
    {
        if ($request instanceof Request) {
            $request = $request->getAdaptee();
        }
        $this->adaptee->handleRequest($form, $request);
    }

    public function isFileUpload($data): bool
    {
        return $this->adaptee->isFileUpload($data);
    }

    public function getUploadFileError($data): ?int
    {
        return $this->adaptee->getUploadFileError($data);
    }
}

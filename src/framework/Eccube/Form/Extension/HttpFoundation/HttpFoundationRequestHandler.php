<?php

namespace Eccube\Form\Extension\HttpFoundation;

use Eccube\HttpFoundation\Request;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationRequestHandler as BaseHttpFoundationRequestHandler;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\RequestHandlerInterface;

class HttpFoundationRequestHandler implements RequestHandlerInterface
{
    private BaseHttpFoundationRequestHandler $httpFoundationRequestHandler;

    public function __construct(BaseHttpFoundationRequestHandler $httpFoundationRequestHandler)
    {
        $this->httpFoundationRequestHandler = $httpFoundationRequestHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(FormInterface $form, $request = null): void
    {
        if ($request instanceof Request) {
            $request = $request->getRequest();
        }

        $this->httpFoundationRequestHandler->handleRequest($form, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function isFileUpload($data): bool
    {
        return $this->httpFoundationRequestHandler->isFileUpload($data);
    }

    /**
     * @return int|null
     */
    public function getUploadFileError($data): ?int
    {
        return $this->httpFoundationRequestHandler->getUploadFileError($data);
    }
}

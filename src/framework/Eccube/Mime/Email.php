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

namespace Eccube\Mime;

use Symfony\Component\Mime\Email as SymfonyEmail;

class Email
{
    private SymfonyEmail $email;

    public function __construct()
    {
        $this->email = new SymfonyEmail();
    }

    private function convertAddress($address)
    {
        return $address instanceof Address
            ? $address->getAddress()
            : $address;
    }

    private function convertAddresses(array $addresses): array
    {
        return array_map(fn ($address) => $this->convertAddress($address), $addresses);
    }

    public function getEmail(): SymfonyEmail
    {
        return $this->email;
    }

    public function subject(string $subject): Email
    {
        $this->email->subject($subject);

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->email->getSubject();
    }

    public function returnPath($address): Email
    {
        $this->email->returnPath($this->convertAddress($address));

        return $this;
    }

    public function from(...$addresses): Email
    {
        $this->email->from(...$this->convertAddresses($addresses));

        return $this;
    }

    public function replyTo(...$addresses): Email
    {
        $this->email->addReplyTo(...$this->convertAddresses($addresses));

        return $this;
    }

    public function to(...$addresses): Email
    {
        $this->email->to(...$this->convertAddresses($addresses));

        return $this;
    }

    public function cc(...$addresses): Email
    {
        $this->email->cc(...$this->convertAddresses($addresses));

        return $this;
    }

    public function bcc(...$addresses): Email
    {
        $this->email->bcc(...$this->convertAddresses($addresses));

        return $this;
    }

    public function text($body, string $charset = 'utf-8'): Email
    {
        $this->email->text($body, $charset);

        return $this;
    }

    public function getTextBody(): ?string
    {
        return $this->email->getTextBody();
    }

    public function html($body, string $charset = 'utf-8'): Email
    {
        $this->email->html($body, $charset);

        return $this;
    }

    public function getHtmlBody(): ?string
    {
        return $this->email->getHtmlBody();
    }

    public function attach($body, string $name = null, string $contentType = null): Email
    {
        $this->email->attach($body, $name, $contentType);

        return $this;
    }

    public function attachFromPath(string $path, string $name = null, string $contentType = null): Email
    {
        $this->email->attachFromPath($path, $name, $contentType);

        return $this;
    }

    public function embed($body, string $name = null, string $contentType = null): Email
    {
        $this->email->embed($body, $name, $contentType);

        return $this;
    }

    public function embedFromPath(string $path, string $name = null, string $contentType = null): Email
    {
        $this->email->embedFromPath($path, $name, $contentType);

        return $this;
    }
}

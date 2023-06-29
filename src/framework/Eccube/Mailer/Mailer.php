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

namespace Eccube\Mailer;

use Eccube\Mailer\Exception\TransportException;
use Eccube\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class Mailer
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @throws TransportException
     */
    public function send(Email $message): void
    {
        try {
            $this->mailer->send($message->getEmail());
        } catch (TransportExceptionInterface $e) {
            throw new TransportException($e->getMessage(), $e->getCode(), $e);
        }
    }
}

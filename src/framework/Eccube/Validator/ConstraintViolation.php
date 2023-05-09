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

namespace Eccube\Validator;

use Symfony\Component\Validator\ConstraintViolationInterface;

class ConstraintViolation
{
    private ConstraintViolationInterface $violation;

    public function __construct(ConstraintViolationInterface $violation)
    {
        $this->violation = $violation;
    }

    /**
     * @return ConstraintViolationInterface
     */
    public function getViolation(): ConstraintViolationInterface
    {
        return $this->violation;
    }

    public function getMessage(): string
    {
        return $this->violation->getMessage();
    }

    public function getMessageTemplate(): string
    {
        return $this->violation->getMessageTemplate();
    }

    public function getParameters(): array
    {
        return $this->violation->getParameters();
    }

    public function getPlural(): ?int
    {
        return $this->violation->getPlural();
    }
}

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

namespace Eccube\Http\Exception;

class TooManyRequestsHttpException extends HttpException
{
    public function __construct($retryAfter = null, ?string $message = '', \Throwable $previous = null, ?int $code = 0, array $headers = [])
    {
        parent::__construct(new \Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException($retryAfter, $message, $previous, $code, $headers));
    }
}

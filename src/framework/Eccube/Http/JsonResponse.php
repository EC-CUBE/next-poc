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

use Symfony\Component\HttpFoundation\JsonResponse as Adaptee;

class JsonResponse extends Response
{
    public const DEFAULT_ENCODING_OPTIONS = Adaptee::DEFAULT_ENCODING_OPTIONS;

    public function __construct($data = null, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct();
        $this->setAdaptee(new Adaptee($data, $status, $headers, $json));
    }
}

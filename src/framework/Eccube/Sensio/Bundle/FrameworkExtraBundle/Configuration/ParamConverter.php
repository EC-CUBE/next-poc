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

namespace Eccube\Sensio\Bundle\FrameworkExtraBundle\Configuration;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter as BaseParamConverter;

/**
 * @Annotation
 */
#[\Attribute(\Attribute::IS_REPEATABLE | \Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD)]
class ParamConverter extends BaseParamConverter
{
}

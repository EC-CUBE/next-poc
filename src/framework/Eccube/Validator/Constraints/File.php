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

namespace Eccube\Validator\Constraints;

use Eccube\Validator\Constraint;
use Symfony\Component\Validator\Constraints\File as Adaptee;

class File extends Constraint
{
    public function __construct(
        array $options = null,
              $maxSize = null,
        bool $binaryFormat = null,
              $mimeTypes = null,
        string $notFoundMessage = null,
        string $notReadableMessage = null,
        string $maxSizeMessage = null,
        string $mimeTypesMessage = null,
        string $disallowEmptyMessage = null,
        string $uploadIniSizeErrorMessage = null,
        string $uploadFormSizeErrorMessage = null,
        string $uploadPartialErrorMessage = null,
        string $uploadNoFileErrorMessage = null,
        string $uploadNoTmpDirErrorMessage = null,
        string $uploadCantWriteErrorMessage = null,
        string $uploadExtensionErrorMessage = null,
        string $uploadErrorMessage = null,
        array $groups = null,
        $payload = null
    ) {
        parent::__construct(new Adaptee($options, $maxSize, $binaryFormat, $mimeTypes, $notFoundMessage, $notReadableMessage, $maxSizeMessage, $mimeTypesMessage, $disallowEmptyMessage, $uploadIniSizeErrorMessage, $uploadFormSizeErrorMessage, $uploadPartialErrorMessage, $uploadNoFileErrorMessage, $uploadNoTmpDirErrorMessage, $uploadCantWriteErrorMessage, $uploadExtensionErrorMessage, $uploadErrorMessage, $groups, $payload));
    }
}

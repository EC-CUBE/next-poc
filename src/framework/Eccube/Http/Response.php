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

use Symfony\Component\HttpFoundation\Response as Adaptee;

class Response
{
    public const HTTP_CONTINUE = Adaptee::HTTP_CONTINUE;
    public const HTTP_SWITCHING_PROTOCOLS = Adaptee::HTTP_SWITCHING_PROTOCOLS;
    public const HTTP_PROCESSING = Adaptee::HTTP_PROCESSING;
    public const HTTP_EARLY_HINTS = Adaptee::HTTP_EARLY_HINTS;
    public const HTTP_OK = Adaptee::HTTP_OK;
    public const HTTP_CREATED = Adaptee::HTTP_CREATED;
    public const HTTP_ACCEPTED = Adaptee::HTTP_ACCEPTED;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = Adaptee::HTTP_NON_AUTHORITATIVE_INFORMATION;
    public const HTTP_NO_CONTENT = Adaptee::HTTP_NO_CONTENT;
    public const HTTP_RESET_CONTENT = Adaptee::HTTP_RESET_CONTENT;
    public const HTTP_PARTIAL_CONTENT = Adaptee::HTTP_PARTIAL_CONTENT;
    public const HTTP_MULTI_STATUS = Adaptee::HTTP_MULTI_STATUS;
    public const HTTP_ALREADY_REPORTED = Adaptee::HTTP_ALREADY_REPORTED;
    public const HTTP_IM_USED = Adaptee::HTTP_IM_USED;
    public const HTTP_MULTIPLE_CHOICES = Adaptee::HTTP_MULTIPLE_CHOICES;
    public const HTTP_MOVED_PERMANENTLY = Adaptee::HTTP_MOVED_PERMANENTLY;
    public const HTTP_FOUND = Adaptee::HTTP_FOUND;
    public const HTTP_SEE_OTHER = Adaptee::HTTP_SEE_OTHER;
    public const HTTP_NOT_MODIFIED = Adaptee::HTTP_NOT_MODIFIED;
    public const HTTP_USE_PROXY = Adaptee::HTTP_USE_PROXY;
    public const HTTP_RESERVED = Adaptee::HTTP_RESERVED;
    public const HTTP_TEMPORARY_REDIRECT = Adaptee::HTTP_TEMPORARY_REDIRECT;
    public const HTTP_PERMANENTLY_REDIRECT = Adaptee::HTTP_PERMANENTLY_REDIRECT;
    public const HTTP_BAD_REQUEST = Adaptee::HTTP_BAD_REQUEST;
    public const HTTP_UNAUTHORIZED = Adaptee::HTTP_UNAUTHORIZED;
    public const HTTP_PAYMENT_REQUIRED = Adaptee::HTTP_PAYMENT_REQUIRED;
    public const HTTP_FORBIDDEN = Adaptee::HTTP_FORBIDDEN;
    public const HTTP_NOT_FOUND = Adaptee::HTTP_NOT_FOUND;
    public const HTTP_METHOD_NOT_ALLOWED = Adaptee::HTTP_METHOD_NOT_ALLOWED;
    public const HTTP_NOT_ACCEPTABLE = Adaptee::HTTP_NOT_ACCEPTABLE;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = Adaptee::HTTP_PROXY_AUTHENTICATION_REQUIRED;
    public const HTTP_REQUEST_TIMEOUT = Adaptee::HTTP_REQUEST_TIMEOUT;
    public const HTTP_CONFLICT = Adaptee::HTTP_CONFLICT;
    public const HTTP_GONE = Adaptee::HTTP_GONE;
    public const HTTP_LENGTH_REQUIRED = Adaptee::HTTP_LENGTH_REQUIRED;
    public const HTTP_PRECONDITION_FAILED = Adaptee::HTTP_PRECONDITION_FAILED;
    public const HTTP_REQUEST_ENTITY_TOO_LARGE = Adaptee::HTTP_REQUEST_ENTITY_TOO_LARGE;
    public const HTTP_REQUEST_URI_TOO_LONG = Adaptee::HTTP_REQUEST_URI_TOO_LONG;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = Adaptee::HTTP_UNSUPPORTED_MEDIA_TYPE;
    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = Adaptee::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE;
    public const HTTP_EXPECTATION_FAILED = Adaptee::HTTP_EXPECTATION_FAILED;
    public const HTTP_I_AM_A_TEAPOT = Adaptee::HTTP_I_AM_A_TEAPOT;
    public const HTTP_MISDIRECTED_REQUEST = Adaptee::HTTP_MISDIRECTED_REQUEST;
    public const HTTP_UNPROCESSABLE_ENTITY = Adaptee::HTTP_UNPROCESSABLE_ENTITY;
    public const HTTP_LOCKED = Adaptee::HTTP_LOCKED;
    public const HTTP_FAILED_DEPENDENCY = Adaptee::HTTP_FAILED_DEPENDENCY;
    public const HTTP_TOO_EARLY = Adaptee::HTTP_TOO_EARLY;
    public const HTTP_UPGRADE_REQUIRED = Adaptee::HTTP_UPGRADE_REQUIRED;
    public const HTTP_PRECONDITION_REQUIRED = Adaptee::HTTP_PRECONDITION_REQUIRED;
    public const HTTP_TOO_MANY_REQUESTS = Adaptee::HTTP_TOO_MANY_REQUESTS;
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = Adaptee::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE;
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = Adaptee::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS;
    public const HTTP_INTERNAL_SERVER_ERROR = Adaptee::HTTP_INTERNAL_SERVER_ERROR;
    public const HTTP_NOT_IMPLEMENTED = Adaptee::HTTP_NOT_IMPLEMENTED;
    public const HTTP_BAD_GATEWAY = Adaptee::HTTP_BAD_GATEWAY;
    public const HTTP_SERVICE_UNAVAILABLE = Adaptee::HTTP_SERVICE_UNAVAILABLE;
    public const HTTP_GATEWAY_TIMEOUT = Adaptee::HTTP_GATEWAY_TIMEOUT;
    public const HTTP_VERSION_NOT_SUPPORTED = Adaptee::HTTP_VERSION_NOT_SUPPORTED;
    public const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = Adaptee::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL;
    public const HTTP_INSUFFICIENT_STORAGE = Adaptee::HTTP_INSUFFICIENT_STORAGE;
    public const HTTP_LOOP_DETECTED = Adaptee::HTTP_LOOP_DETECTED;
    public const HTTP_NOT_EXTENDED = Adaptee::HTTP_NOT_EXTENDED;
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = Adaptee::HTTP_NETWORK_AUTHENTICATION_REQUIRED;

    private Adaptee $adaptee;

    public ResponseHeader $headers;

    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        $this->setAdaptee(new Adaptee($content, $status, $headers));
    }

    protected function setAdaptee(Adaptee $adaptee)
    {
        $this->adaptee = $adaptee;
        $this->headers = new ResponseHeader($adaptee->headers);
    }

    public function setContent(?string $content): self
    {
        $this->adaptee->setContent($content);
        return $this;
    }

    public function getAdaptee()
    {
        return $this->adaptee;
    }
}

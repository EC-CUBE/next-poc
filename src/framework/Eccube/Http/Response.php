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

use Symfony\Component\HttpFoundation\Response as HttpResponse;

class Response
{
    public const HTTP_CONTINUE = HttpResponse::HTTP_CONTINUE;
    public const HTTP_SWITCHING_PROTOCOLS = HttpResponse::HTTP_SWITCHING_PROTOCOLS;
    public const HTTP_PROCESSING = HttpResponse::HTTP_PROCESSING;
    public const HTTP_EARLY_HINTS = HttpResponse::HTTP_EARLY_HINTS;
    public const HTTP_OK = HttpResponse::HTTP_OK;
    public const HTTP_CREATED = HttpResponse::HTTP_CREATED;
    public const HTTP_ACCEPTED = HttpResponse::HTTP_ACCEPTED;
    public const HTTP_NON_AUTHORITATIVE_INFORMATION = HttpResponse::HTTP_NON_AUTHORITATIVE_INFORMATION;
    public const HTTP_NO_CONTENT = HttpResponse::HTTP_NO_CONTENT;
    public const HTTP_RESET_CONTENT = HttpResponse::HTTP_RESET_CONTENT;
    public const HTTP_PARTIAL_CONTENT = HttpResponse::HTTP_PARTIAL_CONTENT;
    public const HTTP_MULTI_STATUS = HttpResponse::HTTP_MULTI_STATUS;
    public const HTTP_ALREADY_REPORTED = HttpResponse::HTTP_ALREADY_REPORTED;
    public const HTTP_IM_USED = HttpResponse::HTTP_IM_USED;
    public const HTTP_MULTIPLE_CHOICES = HttpResponse::HTTP_MULTIPLE_CHOICES;
    public const HTTP_MOVED_PERMANENTLY = HttpResponse::HTTP_MOVED_PERMANENTLY;
    public const HTTP_FOUND = HttpResponse::HTTP_FOUND;
    public const HTTP_SEE_OTHER = HttpResponse::HTTP_SEE_OTHER;
    public const HTTP_NOT_MODIFIED = HttpResponse::HTTP_NOT_MODIFIED;
    public const HTTP_USE_PROXY = HttpResponse::HTTP_USE_PROXY;
    public const HTTP_RESERVED = HttpResponse::HTTP_RESERVED;
    public const HTTP_TEMPORARY_REDIRECT = HttpResponse::HTTP_TEMPORARY_REDIRECT;
    public const HTTP_PERMANENTLY_REDIRECT = HttpResponse::HTTP_PERMANENTLY_REDIRECT;
    public const HTTP_BAD_REQUEST = HttpResponse::HTTP_BAD_REQUEST;
    public const HTTP_UNAUTHORIZED = HttpResponse::HTTP_UNAUTHORIZED;
    public const HTTP_PAYMENT_REQUIRED = HttpResponse::HTTP_PAYMENT_REQUIRED;
    public const HTTP_FORBIDDEN = HttpResponse::HTTP_FORBIDDEN;
    public const HTTP_NOT_FOUND = HttpResponse::HTTP_NOT_FOUND;
    public const HTTP_METHOD_NOT_ALLOWED = HttpResponse::HTTP_METHOD_NOT_ALLOWED;
    public const HTTP_NOT_ACCEPTABLE = HttpResponse::HTTP_NOT_ACCEPTABLE;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = HttpResponse::HTTP_PROXY_AUTHENTICATION_REQUIRED;
    public const HTTP_REQUEST_TIMEOUT = HttpResponse::HTTP_REQUEST_TIMEOUT;
    public const HTTP_CONFLICT = HttpResponse::HTTP_CONFLICT;
    public const HTTP_GONE = HttpResponse::HTTP_GONE;
    public const HTTP_LENGTH_REQUIRED = HttpResponse::HTTP_LENGTH_REQUIRED;
    public const HTTP_PRECONDITION_FAILED = HttpResponse::HTTP_PRECONDITION_FAILED;
    public const HTTP_REQUEST_ENTITY_TOO_LARGE = HttpResponse::HTTP_REQUEST_ENTITY_TOO_LARGE;
    public const HTTP_REQUEST_URI_TOO_LONG = HttpResponse::HTTP_REQUEST_URI_TOO_LONG;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = HttpResponse::HTTP_UNSUPPORTED_MEDIA_TYPE;
    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = HttpResponse::HTTP_REQUESTED_RANGE_NOT_SATISFIABLE;
    public const HTTP_EXPECTATION_FAILED = HttpResponse::HTTP_EXPECTATION_FAILED;
    public const HTTP_I_AM_A_TEAPOT = HttpResponse::HTTP_I_AM_A_TEAPOT;
    public const HTTP_MISDIRECTED_REQUEST = HttpResponse::HTTP_MISDIRECTED_REQUEST;
    public const HTTP_UNPROCESSABLE_ENTITY = HttpResponse::HTTP_UNPROCESSABLE_ENTITY;
    public const HTTP_LOCKED = HttpResponse::HTTP_LOCKED;
    public const HTTP_FAILED_DEPENDENCY = HttpResponse::HTTP_FAILED_DEPENDENCY;
    public const HTTP_TOO_EARLY = HttpResponse::HTTP_TOO_EARLY;
    public const HTTP_UPGRADE_REQUIRED = HttpResponse::HTTP_UPGRADE_REQUIRED;
    public const HTTP_PRECONDITION_REQUIRED = HttpResponse::HTTP_PRECONDITION_REQUIRED;
    public const HTTP_TOO_MANY_REQUESTS = HttpResponse::HTTP_TOO_MANY_REQUESTS;
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = HttpResponse::HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE;
    public const HTTP_UNAVAILABLE_FOR_LEGAL_REASONS = HttpResponse::HTTP_UNAVAILABLE_FOR_LEGAL_REASONS;
    public const HTTP_INTERNAL_SERVER_ERROR = HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
    public const HTTP_NOT_IMPLEMENTED = HttpResponse::HTTP_NOT_IMPLEMENTED;
    public const HTTP_BAD_GATEWAY = HttpResponse::HTTP_BAD_GATEWAY;
    public const HTTP_SERVICE_UNAVAILABLE = HttpResponse::HTTP_SERVICE_UNAVAILABLE;
    public const HTTP_GATEWAY_TIMEOUT = HttpResponse::HTTP_GATEWAY_TIMEOUT;
    public const HTTP_VERSION_NOT_SUPPORTED = HttpResponse::HTTP_VERSION_NOT_SUPPORTED;
    public const HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL = HttpResponse::HTTP_VARIANT_ALSO_NEGOTIATES_EXPERIMENTAL;
    public const HTTP_INSUFFICIENT_STORAGE = HttpResponse::HTTP_INSUFFICIENT_STORAGE;
    public const HTTP_LOOP_DETECTED = HttpResponse::HTTP_LOOP_DETECTED;
    public const HTTP_NOT_EXTENDED = HttpResponse::HTTP_NOT_EXTENDED;
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = HttpResponse::HTTP_NETWORK_AUTHENTICATION_REQUIRED;

    private HttpResponse $response;

    public function __construct(?string $content = '', int $status = 200, array $headers = [])
    {
        $this->response = new HttpResponse($content, $status, $headers);
    }

    public function getAdaptee()
    {
        return $this->response;
    }
}

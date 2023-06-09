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

namespace Eccube\Tests\Security;

use Eccube\Entity\Customer;
use Eccube\Entity\Member;
use Eccube\Security\SecurityContext;
use Eccube\Tests\EccubeTestCase;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SecurityContextTest extends EccubeTestCase
{
    protected ?SecurityContext $securityContext;

    protected function setUp(): void
    {
        parent::setUp();

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);

        $this->securityContext = new SecurityContext($tokenStorage, $authorizationChecker);
    }

    public function testGetLoginCustomerReturnsNullWhenNoUserIsLoggedIn()
    {
        $this->assertNull($this->securityContext->getLoginCustomer());
    }

    public function testGetLoginCustomerReturnsNullWhenLoggedInUserIsNotACustomer()
    {
        $token = $this->createMock(TokenInterface::class);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method('isGranted')->willReturn(false);

        $securityContext = new SecurityContext($tokenStorage, $authorizationChecker);

        $this->assertNull($securityContext->getLoginCustomer());
    }

    public function testGetLoginCustomerReturnsCustomerWhenLoggedInUserIsACustomer()
    {
        $customer = $this->createMock(Customer::class);

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($customer);

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method('isGranted')->willReturn(true);

        $securityContext = new SecurityContext($tokenStorage, $authorizationChecker);

        $this->assertSame($customer, $securityContext->getLoginCustomer());
    }

    public function testGetLoginMemberReturnsNullWhenNoUserIsLoggedIn()
    {
        $this->assertNull($this->securityContext->getLoginMember());
    }

    public function testGetLoginMemberReturnsNullWhenLoggedInUserIsNotAMember()
    {
        $token = $this->createMock(TokenInterface::class);
        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method('isGranted')->willReturn(false);

        $securityContext = new SecurityContext($tokenStorage, $authorizationChecker);

        $this->assertNull($securityContext->getLoginMember());
    }

    public function testGetLoginMemberReturnsMemberWhenLoggedInUserIsAMember()
    {
        $member = $this->createMock(Member::class);

        $token = $this->createMock(TokenInterface::class);
        $token->method('getUser')->willReturn($member);

        $tokenStorage = $this->createMock(TokenStorageInterface::class);
        $tokenStorage->method('getToken')->willReturn($token);

        $authorizationChecker = $this->createMock(AuthorizationCheckerInterface::class);
        $authorizationChecker->method('isGranted')->willReturn(true);

        $securityContext = new SecurityContext($tokenStorage, $authorizationChecker);

        $this->assertSame($member, $securityContext->getLoginMember());
    }
}

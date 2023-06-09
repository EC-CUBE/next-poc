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

namespace Eccube\Tests\Security\PasswordHasher;

use Eccube\Security\PasswordHasher\EccubePasswordHasher;
use Eccube\Tests\EccubeTestCase;


class EccubePasswordHasherTest extends EccubeTestCase
{
    public function testHashWithPlainAuthType()
    {
        $hasher = new EccubePasswordHasher('magic', EccubePasswordHasher::AUTH_TYPE_PLAIN, 'sha256');
        $password = 'password';
        $expected = $password;
        $actual = $hasher->hash($password);
        $this->assertEquals($expected, $actual);
    }

    public function testHashWithHmacAuthType()
    {
        $salt = 'salt';
        $hasher = new EccubePasswordHasher('magic', 'HMAC', 'sha256');
        $password = 'password';
        $expected = hash_hmac('sha256', $password.':magic', $salt);
        $actual = $hasher->hash($password, $salt);
        $this->assertEquals($expected, $actual);
    }

    public function testHashWithSalt()
    {
        $hasher = new EccubePasswordHasher('magic', EccubePasswordHasher::AUTH_TYPE_PLAIN, 'sha256');
        $password = 'password';
        $salt = 'salt';
        $expected = $password;
        $actual = $hasher->hash($password, $salt);
        $this->assertEquals($expected, $actual);
    }

    public function testVerifyWithPlainAuthType()
    {
        $salt = 'salt';
        $hasher = new EccubePasswordHasher('magic', EccubePasswordHasher::AUTH_TYPE_PLAIN, 'sha256');
        $password = 'password';
        $hash = $hasher->hash($password, $salt);
        $this->assertTrue($hasher->verify($hash, $password, $salt));
    }

    public function testVerifyWithHmacAuthType()
    {
        $salt = 'salt';
        $hasher = new EccubePasswordHasher('magic', 'HMAC', 'sha256');
        $password = 'password';
        $hash = $hasher->hash($password, $salt);
        $this->assertTrue($hasher->verify($hash, $password, $salt));
    }

    public function testVerifyWithEmptySalt()
    {
        $hasher = new EccubePasswordHasher('magic', 'HMAC', 'sha256');
        $password = 'password';
        $hash = sha1($password.':magic');
        $this->assertTrue($hasher->verify($hash, $password, ''));
    }

    public function testVerifyWithEmptyHash()
    {
        $hasher = new EccubePasswordHasher('magic', EccubePasswordHasher::AUTH_TYPE_PLAIN, 'sha256');
        $password = 'password';
        $hash = '';
        $this->assertFalse($hasher->verify($hash, $password));
    }

    public function testVerifyWithIncorrectPassword()
    {
        $hasher = new EccubePasswordHasher('magic', EccubePasswordHasher::AUTH_TYPE_PLAIN, 'sha256');
        $password = 'password';
        $hash = $hasher->hash($password);
        $this->assertFalse($hasher->verify($hash, 'incorrect'));
    }
}

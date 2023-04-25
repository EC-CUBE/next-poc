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

namespace Eccube\Controller;

use Nyholm\Psr7\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Eccube\Routing\Annotation\Route;
use Psr\Http\Message\ServerRequestInterface;

class TopController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     * @Template("index.twig")
     */
    public function index()
    {
        return [];
    }

    /**
     * @Route("/psr7")
     */
    public function psr7(ServerRequestInterface $request)
    {
        $response = new Response(200, [], 'hello');

        return $response;
    }
}

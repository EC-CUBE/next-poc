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

namespace Eccube\Command;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Eccube\Service\EntityProxyService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenerateProxyCommand extends Command
{
    protected static $defaultName = 'eccube:generate:proxies';

    /**
     * @var EntityProxyService
     */
    private $entityProxyService;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(EntityProxyService $entityProxyService, ContainerInterface $container)
    {
        parent::__construct();
        $this->entityProxyService = $entityProxyService;
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setDescription('Generate entity proxies');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectDir = $this->container->getParameter('kernel.project_dir');

        // アノテーションを読み込めるように設定.
        AnnotationRegistry::registerAutoloadNamespace('Eccube\Annotation', $projectDir.'/src/framework');

        $includeDirs = [$projectDir.'/app/Customize/Entity'];

        $enabledPlugins = $this->container->getParameter('eccube.plugins.enabled');
        foreach ($enabledPlugins as $code) {
            if (file_exists($projectDir.'/app/Plugin/'.$code.'/Entity')) {
                $includeDirs[] = $projectDir.'/app/Plugin/'.$code.'/Entity';
            }
        }

        $this->entityProxyService->generate(
            $includeDirs,
            [],
            $projectDir.'/app/proxy/entity',
            $output
        );

        return 0;
    }
}

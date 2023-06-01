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

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Eccube\Doctrine\ORM\Mapping\Driver\XmlDriver;
use Eccube\Service\EntityProxyService;
use Eccube\Service\PluginContext;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class PluginEnableCommand extends Command
{
    use PluginCommandTrait;
    protected static $defaultName = 'eccube:plugin:enable';

    private ContainerInterface $container;
    private EntityManagerInterface $entityManager;
    private EntityProxyService $entityProxyService;
    private PluginContext $pluginContext;

    public function __construct(
        ContainerInterface $container,
        EntityManagerInterface $entityManager,
        EntityProxyService $entityProxyService,
        PluginContext $pluginContext)
    {
        parent::__construct();

        $this->container = $container;
        $this->entityManager = $entityManager;
        $this->entityProxyService = $entityProxyService;
        $this->pluginContext = $pluginContext;
    }

    protected function configure()
    {
        $this
            ->addOption('code', null, InputOption::VALUE_REQUIRED, 'plugin code');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $code = $input->getOption('code');
        $plugin = $this->pluginRepository->findByCode($code);
        if (is_null($plugin)) {
            $io->error("Plugin `$code` is not found.");

            return 1;
        }

        if (!$plugin->isInitialized()) {
            $projectDir = $this->container->getParameter('kernel.project_dir');
            $this->entityManager->getMetadataFactory()->setCacheDriver(null);
            $chain = $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getDriver();
            $drivers = $chain->getDrivers();
            foreach ($drivers as $namespace => $driver) {
                if (\str_starts_with($namespace, 'Eccube') && $driver instanceof XmlDriver) {
                    $driver->clear();
                    $this->pluginContext->setCode($code);
                    $this->pluginContext->setInstall();
                    $driver->setPluginContext($this->pluginContext);

                    $path = $projectDir.'/app/Plugin/'.$code.'/Resource/doctrine/mapping';
                    $ns = 'Plugin\\'.$code.'\\Entity';
                    $locator = $driver->getLocator();
                    $locator->addNamespacePrefixes([$path => $ns]);

                    $chain = $this->entityManager->getConfiguration()->getMetadataDriverImpl()->getDriver();
                    $chain->addDriver($driver, $ns);

                    // driverのインスタンスはすべて同一
                    break;
                }
            }

            $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();
            $tool = new SchemaTool($this->entityManager);
            $tool->updateSchema($metadata, true);
        }

        $this->pluginService->enable($plugin);
        $this->clearCache($io);

        $io->success('Plugin Enabled.');

        return 0;
    }
}

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

namespace Eccube\Doctrine\ORM\Mapping\Driver;

use Doctrine\ORM\Mapping\Driver\XmlDriver as BaseXmlDriver;
use Eccube\Service\PluginContext;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class XmlDriver extends BaseXmlDriver
{
    private ContainerBagInterface $containerBag;

    private string $projectDir;

    private array $entityExtensions = [];

    private ?PluginContext $pluginContext = null;

    public function setContainerBag(ContainerBagInterface $containerBag)
    {
        $this->containerBag = $containerBag;
    }

    public function setProjectDir(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function setPluginContext(PluginContext $pluginContext)
    {
        $this->pluginContext = $pluginContext;
    }

    public static function newDriver(XmlDriver $oldDriver, PluginContext $pluginContext)
    {
        $result = new XmlDriver($oldDriver->getLocator());
        $result->setPluginContext($pluginContext);
        $result->setContainerBag($oldDriver->containerBag);
        $result->setProjectDir($oldDriver->projectDir);

        return $result;
    }

    public function clear(): void
    {
        $this->classCache = null;
        $this->entityExtensions = [];
        $this->pluginContext = null;
    }

    protected function initialize()
    {
        foreach ($this->getEntityExtensionFiles() as $entityExtensionFile) {
            $entityExtensions = $this->loadEntityExtensionFile($entityExtensionFile);
            foreach ($entityExtensions as $class => $elements) {
                if (isset($this->entityExtensions[$class])) {
                    $this->entityExtensions[$class] = array_merge($this->entityExtensions[$class], $elements);
                } else {
                    $this->entityExtensions[$class] = $elements;
                }
            }
        }

        parent::initialize();
    }

    protected function loadMappingFile($file)
    {
        $mappingXml = file_get_contents($file);
        $class = $this->findMappingClass($file);
        if (!empty($this->entityExtensions[$class])) {
            $mappingXml = $this->mergeEntityExtension($mappingXml, $this->entityExtensions[$class]);
        }

        $transformedXml = $this->transformMappingXml($mappingXml);
        $transformedFile = $this->getTransformedMappingFilePath($file);
        (new Filesystem())->mkdir(dirname($transformedFile));
        file_put_contents($transformedFile, $transformedXml);

        return parent::loadMappingFile($transformedFile);
    }

    private function getTransformedMappingFilePath(string $file): string
    {
        $matches = [];
        if (preg_match('|Eccube/Resource/doctrine/mapping/.+\.orm\.xml$|i', $file)) {
            return $this->projectDir.'/app/mapping/eccube/'.basename($file);
        } elseif (preg_match('|Customize/Resource/doctrine/mapping/.+\.orm\.xml$|i', $file)) {
            return $this->projectDir.'/app/mapping/customize/'.basename($file);
        } elseif (preg_match('|Plugin/(.+)/Resource/doctrine/mapping/.+\.orm\.xml$|i', $file, $matches)) {
            $code = $matches[1];

            return $this->projectDir.'/app/mapping/plugin/'.$code.'/'.basename($file);
        } elseif (preg_match('|/(.+)/Resource/doctrine/mapping/.+\.orm\.xml$|i', $file, $matches)) {
            // eccube:composer:require ec-cube/Sample --from=./path/to/Sample
            $code = $matches[1];

            return $this->projectDir.'/app/mapping/plugin/'.$code.'/'.basename($file);
        } else {
            throw new \LogicException($file);
        }
    }

    private function transformMappingXml(string $xml): string
    {
        $processor = $this->createXsltProcessor();
        $document = new \DOMDocument();
        $document->loadXML($xml);
        $transformed = $processor->transformToXML($document);
        $transformed = str_replace('<entity xmlns=""', '<entity', $transformed);

        return $transformed;
    }

    private function createXsltProcessor(): \XSLTProcessor
    {
        $xsl = <<<EOL
<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="xml" version="1.0" encoding="utf-8" indent="yes"/>
    <xsl:template match="/">
        <xsl:apply-templates select="mapping/entity"/>
    </xsl:template>
    <xsl:template match="mapping/entity">
        <doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping https://www.doctrine-project.org/schemas/orm/doctrine-mapping.xsd">
            <xsl:copy-of select="."/>
        </doctrine-mapping>
    </xsl:template>
</xsl:stylesheet>
EOL;
        $document = new \DOMDocument();
        $document->loadXML($xsl);
        $xsltProcessor = new \XSLTProcessor();
        $xsltProcessor->importStyleSheet($document);

        return $xsltProcessor;
    }

    private function loadEntityExtensionFile(string $file)
    {
        $ext = new \DOMDocument();
        $ext->loadXML(file_get_contents($file));
        $entities = $ext->getElementsByTagName('entity');
        $targets = [];
        foreach ($entities as $entity) {
            $target = $entity->attributes['target']->value;
            if ($target) {
                $targetClass = new \ReflectionClass($target);
                // TODO いったんCustomizeもしくはPluginのTraitをuseしているプロキシがあれば対象にする/entity_extension.xmlでTraitを指定するか、命名規約でカバーするか検討
                $traits = $targetClass->getTraitNames();
                $filtered = array_filter($traits, fn ($t) => \str_starts_with($t, 'Customize\\') || \str_starts_with($t, 'Plugin\\'));
                if ($traits !== $filtered) {
                    foreach ($entity->childNodes as $child) {
                        if ($child instanceof \DOMElement) {
                            $targets[$target][] = $child;
                        }
                    }
                }
            }
        }

        return $targets;
    }

    private function mergeEntityExtension($xml, array $elements)
    {
        $target = new \DOMDocument();
        $target->loadXML($xml);
        foreach ($elements as $element) {
            $element = $target->importNode($element, true);
            $target->getElementsByTagName('entity')->item(0)->appendChild($element);
        }

        return $target->saveXML();
    }

    private function findMappingClass(string $file)
    {
        $file = realpath($file);
        $classNames = $this->locator->getAllClassNames();
        foreach ($classNames as $className) {
            $mappingFile = realpath($this->locator->findMappingFile($className));
            if ($mappingFile === $file) {
                return $className;
            }
        }
    }

    private function getEntityExtensionFiles(): array
    {
        $projectDir = $this->containerBag->get('kernel.project_dir');
        $plugins = $this->getTargetPlugins();
        $pluginDirs = array_map(fn ($code) => $projectDir.'/app/Plugin/'.$code.'/Resource/doctrine', $plugins);
        $pluginDirs = array_filter($pluginDirs, fn ($dir) => file_exists($dir));

        $entityExtensionFiles = (new Finder())
            ->in(array_merge([$projectDir.'/app/Customize/Resource/doctrine'], $pluginDirs))
            ->name('entity_extension.xml')
            ->files();

        return array_keys(iterator_to_array($entityExtensionFiles));
    }

    private function getTargetPlugins(): array
    {
        $plugins = $this->containerBag->get('eccube.plugins.installed');

        if ($this->pluginContext !== null && $this->pluginContext->isInstall()) {
            $plugins[] = $this->pluginContext->getCode();
        }
        if ($this->pluginContext !== null && $this->pluginContext->isUninstall()) {
            $plugins = array_filter($plugins, fn ($plugin) => $plugin !== $this->pluginContext->getCode());
        }

        return $plugins;
    }
}

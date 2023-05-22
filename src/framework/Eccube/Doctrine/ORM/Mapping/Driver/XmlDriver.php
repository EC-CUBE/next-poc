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
use Eccube\Service\EntityProxyService;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class XmlDriver extends BaseXmlDriver
{
    private string $projectDir;

    private array $entityExtensionFiles;

    private array $entityExtensions = [];

    private EntityProxyService $entityProxyService;

    public function setProjectDir(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function setEntityExtensionFiles(array $entityExtensionFiles)
    {
        $this->entityExtensionFiles = $entityExtensionFiles;
    }

    public function setEntityProxyService(EntityProxyService $entityProxyService)
    {
        $this->entityProxyService = $entityProxyService;
    }

    protected function initialize()
    {
        foreach ($this->entityExtensionFiles as $entityExtensionFile) {
            $this->entityExtensions = array_merge(
                $this->entityExtensions,
                $this->loadEntityExtensionFile($entityExtensionFile)
            );
        }

        $pluginDirs = (new Finder())
            ->in($this->projectDir.'/app/Plugin')
            ->sortByName()
            ->depth(0)
            ->directories();

        $dirs = [];
        foreach ($pluginDirs as $dir) {
            $dirs[] = $dir->getRealPath().'/Entity';
        }

        $this->entityProxyService->generate(
            array_merge([$this->projectDir.'/app/Customize/Entity'], $dirs),
            [],
            $this->projectDir.'/app/proxy/entity'
        );

        return parent::initialize();
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

    private function getTransformedMappingFilePath(string $file)
    {
        $matches = [];
        if (preg_match('|Eccube/Resource/doctrine/mapping/.+\.orm\.xml|i', $file)) {
            return $this->projectDir.'/app/mapping/eccube/'.basename($file);
        } elseif (preg_match('|Customize/Resource/doctrine/mapping/.+\.orm\.xml|i', $file)) {
            return $this->projectDir.'/app/mapping/customize/'.basename($file);
        } elseif (preg_match('|Plugin/(.+)/Resource/doctrine/mapping/.+\.orm\.xml|i', $file, $matches)) {
            $code = $matches[1];
            return $this->projectDir.'/app/mapping/plugin/'.$code.'/'.basename($file);
        } else {
            throw new \LogicException();
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
            if ($entity->attributes['target']->value) {
                foreach ($entity->childNodes as $child) {
                    if ($child instanceof \DOMElement) {
                        $targets[$entity->attributes['target']->value][] = $child;
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
}

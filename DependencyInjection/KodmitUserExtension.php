<?php

namespace Kodmit\UserBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Bundle\MakerBundle\Util\YamlSourceManipulator;
use Symfony\Bundle\MakerBundle\Generator;

class KodmitUserExtension extends Extension
{

    /** @var YamlSourceManipulator */
    private $manipulator;

    public function load(array $configs, ContainerBuilder $container, Generator $generator)
    {


        $yamlSource = './config/services.yaml';
        $this->manipulator = new YamlSourceManipulator($yamlSource);

        $this->normalizeSecurityYamlFile();

        $newData = $this->manipulator->getData();

        if (!isset($newData['services']['Kodmit\\UserBundle\\'])) {
            $newData['services'] = ['Kodmit\\UserBundle\\' => ["resource" => "testttt"]];
        }

        $this->manipulator->setData($newData);
        $contents = $this->manipulator->getContents();

        $generator->dumpFile($yamlSource, $contents);


    }

    private function normalizeSecurityYamlFile()
    {
        if (!isset($this->manipulator->getData()['security'])) {
            $newData = $this->manipulator->getData();
            $newData['security'] = [];
            $this->manipulator->setData($newData);
        }
    }

}
<?php

namespace Yokai\SafeDelete\Bridge\Symfony\Framework\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Yokai\SafeDelete\Usage\Descriptor\SupportsObjectDescriptorInterface;
use Yokai\SafeDelete\Usage\Finder\SupportsUsageFinderInterface;

class YokaiSafeDeleteExtension extends Extension
{
    private const SERVICES_LOADING_MAP = [
        'doctrine/orm.xml' => \Doctrine\ORM\EntityManagerInterface::class,
    ];

    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(SupportsUsageFinderInterface::class)
            ->addTag('yokai_safe_delete.usage_finder');

        $container->registerForAutoconfiguration(SupportsObjectDescriptorInterface::class)
            ->addTag('yokai_safe_delete.object_descriptor');

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        foreach (self::SERVICES_LOADING_MAP as $file => $classOrInterface) {
            if (class_exists($classOrInterface) || interface_exists($classOrInterface)) {
                $loader->load($file);
            }
        }
    }
}

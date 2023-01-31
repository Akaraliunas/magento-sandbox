<?php

namespace Akaraliunas\AnimeEAV\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Akaraliunas\AnimeEAV\Setup\AnimeSetupFactory;

class InstallData implements InstallDataInterface
{
    protected $animeSetupFactory;
    public function __construct(AnimeSetupFactory $animeSetupFactory)
    {
        $this->animeSetupFactory = $animeSetupFactory;
    }
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $animeSetup = $this->animeSetupFactory->create(['setup' => $setup]);
        $setup->startSetup();
        $animeSetup->installEntities();
        $entities = $animeSetup->getDefaultEntities();

        foreach ($entities as $entityName => $entity) {
            $animeSetup->addEntityType($entityName, $entity);
        }
        $setup->endSetup();
    }
}

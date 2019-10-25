<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\CmsSlotDataImport;

use Spryker\Zed\CmsSlotDataImport\Dependency\Facade\CmsSlotDataImportToCmsSlotFacadeBridge;
use Spryker\Zed\CmsSlotDataImport\Dependency\Service\CmsSlotDataImportToUtilTextServiceBridge;
use Spryker\Zed\DataImport\DataImportDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Spryker\Zed\CmsSlotDataImport\CmsSlotDataImportConfig getConfig()
 */
class CmsSlotDataImportDependencyProvider extends DataImportDependencyProvider
{
    public const FACADE_CMS_SLOT = 'FACADE_CMS_SLOT';
    public const SERVICE_UTIL_TEXT = 'SERVICE_UTIL_TEXT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addCmsSlotFacade($container);
        $container = $this->addUtilTextService($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCmsSlotFacade(Container $container): Container
    {
        $container->set(static::FACADE_CMS_SLOT, function (Container $container) {
            return new CmsSlotDataImportToCmsSlotFacadeBridge(
                $container->getLocator()->cmsSlot()->facade()
            );
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addUtilTextService(Container $container): Container
    {
        $container->set(static::SERVICE_UTIL_TEXT, function (Container $container) {
            return new CmsSlotDataImportToUtilTextServiceBridge(
                $container->getLocator()->utilText()->service()
            );
        });

        return $container;
    }
}

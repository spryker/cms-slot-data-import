<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\CmsSlotDataImport\Business;

use Spryker\Zed\CmsSlotDataImport\Business\DataImportStep\CheckCmsSlotDataStep;
use Spryker\Zed\CmsSlotDataImport\Business\DataImportStep\CheckCmsSlotTemplateDataStep;
use Spryker\Zed\CmsSlotDataImport\Business\DataImportStep\CmsSlotMutatorDataStep;
use Spryker\Zed\CmsSlotDataImport\Business\DataImportStep\CmsSlotTemplateWriterStep;
use Spryker\Zed\CmsSlotDataImport\Business\DataImportStep\CmsSlotWriterStep;
use Spryker\Zed\CmsSlotDataImport\Business\DataImportStep\TemplatePathToCmsSlotTemplateIdStep;
use Spryker\Zed\CmsSlotDataImport\CmsSlotDataImportDependencyProvider;
use Spryker\Zed\CmsSlotDataImport\Dependency\Facade\CmsSlotDataImportToCmsSlotFacadeInterface;
use Spryker\Zed\CmsSlotDataImport\Dependency\Service\CmsSlotDataImportToUtilTextServiceInterface;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;

/**
 * @method \Spryker\Zed\CmsSlotDataImport\CmsSlotDataImportConfig getConfig()
 * @method \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerTransactionAware createTransactionAwareDataSetStepBroker($bulkSize = null)
 * @method \Spryker\Zed\DataImport\Business\Model\DataImporter getCsvDataImporterFromConfig(\Generated\Shared\Transfer\DataImporterConfigurationTransfer $dataImporterConfigurationTransfer)
 */
class CmsSlotDataImportBusinessFactory extends DataImportBusinessFactory
{
    public function getCmsSlotDataImport(): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig($this->getConfig()->getCmsSlotDataImporterConfiguration());

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createCmsSlotMutatorDataStep());
        $dataSetStepBroker->addStep($this->createCheckCmsSlotDataStep());
        $dataSetStepBroker->addStep($this->createTemplatePathToCmsSlotTemplateIdStep());
        $dataSetStepBroker->addStep($this->createCmsSlotWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    public function getCmsSlotTemplateDataImport(): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig($this->getConfig()->getCmsSlotTemplateDataImporterConfiguration());

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createCheckCmsSlotTemplateDataStep());
        $dataSetStepBroker->addStep($this->createCmsSlotTemplateWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    public function createCheckCmsSlotTemplateDataStep(): DataImportStepInterface
    {
        return new CheckCmsSlotTemplateDataStep($this->getCmsSlotFacade());
    }

    public function createCmsSlotTemplateWriterStep(): DataImportStepInterface
    {
        return new CmsSlotTemplateWriterStep($this->getUtilTextService());
    }

    public function createCmsSlotMutatorDataStep(): DataImportStepInterface
    {
        return new CmsSlotMutatorDataStep();
    }

    public function createCheckCmsSlotDataStep(): DataImportStepInterface
    {
        return new CheckCmsSlotDataStep($this->getCmsSlotFacade());
    }

    public function createTemplatePathToCmsSlotTemplateIdStep(): DataImportStepInterface
    {
        return new TemplatePathToCmsSlotTemplateIdStep();
    }

    public function createCmsSlotWriterStep(): DataImportStepInterface
    {
        return new CmsSlotWriterStep();
    }

    public function getCmsSlotFacade(): CmsSlotDataImportToCmsSlotFacadeInterface
    {
        return $this->getProvidedDependency(CmsSlotDataImportDependencyProvider::FACADE_CMS_SLOT);
    }

    public function getUtilTextService(): CmsSlotDataImportToUtilTextServiceInterface
    {
        return $this->getProvidedDependency(CmsSlotDataImportDependencyProvider::SERVICE_UTIL_TEXT);
    }
}

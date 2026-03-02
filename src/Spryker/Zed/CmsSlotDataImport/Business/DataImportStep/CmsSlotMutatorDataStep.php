<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\CmsSlotDataImport\Business\DataImportStep;

use Spryker\Zed\CmsSlotDataImport\Business\DataSet\CmsSlotDataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CmsSlotMutatorDataStep implements DataImportStepInterface
{
    public function execute(DataSetInterface $dataSet): void
    {
        $this->mutateIsActiveDataSetValue($dataSet);
    }

    protected function mutateIsActiveDataSetValue(DataSetInterface $dataSet): void
    {
        $dataSet[CmsSlotDataSetInterface::CMS_SLOT_IS_ACTIVE] = filter_var(
            $dataSet[CmsSlotDataSetInterface::CMS_SLOT_IS_ACTIVE],
            FILTER_VALIDATE_BOOLEAN,
        );
    }
}

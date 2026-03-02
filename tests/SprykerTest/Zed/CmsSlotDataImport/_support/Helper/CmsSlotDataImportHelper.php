<?php

/**
 * MIT License
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Zed\CmsSlotDataImport\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\CmsSlotTemplateBuilder;
use Generated\Shared\Transfer\CmsSlotTemplateTransfer;
use Orm\Zed\CmsSlot\Persistence\SpyCmsSlotQuery;
use Orm\Zed\CmsSlot\Persistence\SpyCmsSlotTemplate;
use Orm\Zed\CmsSlot\Persistence\SpyCmsSlotTemplateQuery;
use Orm\Zed\CmsSlot\Persistence\SpyCmsSlotToCmsSlotTemplateQuery;
use Orm\Zed\CmsSlotBlock\Persistence\SpyCmsSlotBlockQuery;

class CmsSlotDataImportHelper extends Module
{
    public function hasCmsSlotTemplate(array $seedData = []): CmsSlotTemplateTransfer
    {
        $this->ensureSpyCmsSlotTemplateTableIsEmpty();

        $cmsSlotTemplateTransfer = (new CmsSlotTemplateBuilder($seedData))->build();
        $cmsSlotTemplateTransfer->setIdCmsSlotTemplate(null);

        $cmsSlotTemplateEntity = new SpyCmsSlotTemplate();
        $cmsSlotTemplateEntity->fromArray($cmsSlotTemplateTransfer->toArray());
        $cmsSlotTemplateEntity->setPathHash('path_hash');
        $cmsSlotTemplateEntity->save();

        $cmsSlotTemplateTransfer->fromArray($cmsSlotTemplateEntity->toArray(), true);

        return $cmsSlotTemplateTransfer;
    }

    public function ensureSpyCmsSlotTableIsEmpty(): void
    {
        $cmsSlotToCmsSlotTemplateQuery = $this->getCmsSlotToCmsSlotTemplateQuery();
        $cmsSlotToCmsSlotTemplateQuery->deleteAll();

        $cmsSlotBlockQuery = $this->getCmsSlotBlockQuery();
        $cmsSlotBlockQuery->deleteAll();

        $cmsSlotQuery = $this->getCmsSlotQuery();
        $cmsSlotQuery->deleteAll();
    }

    public function ensureSpyCmsSlotTemplateTableIsEmpty(): void
    {
        $cmsSlotToCmsSlotTemplateQuery = $this->getCmsSlotToCmsSlotTemplateQuery();
        $cmsSlotToCmsSlotTemplateQuery->deleteAll();

        $cmsSlotBlockQuery = $this->getCmsSlotBlockQuery();
        $cmsSlotBlockQuery->deleteAll();

        $cmsSlotTemplateQuery = $this->getCmsSlotTemplateQuery();
        $cmsSlotTemplateQuery->deleteAll();
    }

    public function assertSpyCmsSlotTableContainsData(): void
    {
        $cmsSlotQuery = $this->getCmsSlotQuery();
        $this->assertTrue($cmsSlotQuery->exists(), 'Expected at least one entry in the database table but database table is empty.');
    }

    public function assertSpyCmsSlotTemplateTableContainsData(): void
    {
        $cmsSlotTemplateQuery = $this->getCmsSlotTemplateQuery();
        $this->assertTrue($cmsSlotTemplateQuery->exists(), 'Expected at least one entry in the database table but database table is empty.');
    }

    protected function getCmsSlotQuery(): SpyCmsSlotQuery
    {
        return SpyCmsSlotQuery::create();
    }

    protected function getCmsSlotTemplateQuery(): SpyCmsSlotTemplateQuery
    {
        return SpyCmsSlotTemplateQuery::create();
    }

    protected function getCmsSlotToCmsSlotTemplateQuery(): SpyCmsSlotToCmsSlotTemplateQuery
    {
        return SpyCmsSlotToCmsSlotTemplateQuery::create();
    }

    protected function getCmsSlotBlockQuery(): SpyCmsSlotBlockQuery
    {
        return SpyCmsSlotBlockQuery::create();
    }
}

<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Model\ResourceModel\CollectionItem;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SwiftOtter\CustomerCollection\Model\CollectionItem;
use SwiftOtter\CustomerCollection\Model\ResourceModel\CollectionItem as CollectionItemResource;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            CollectionItem::class,
            CollectionItemResource::class
        );
    }
}

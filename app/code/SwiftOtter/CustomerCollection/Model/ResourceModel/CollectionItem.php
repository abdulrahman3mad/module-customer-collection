<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class CollectionItem extends AbstractDb
{
    protected function _construct()
    {
        $this->_init("customer_collection_item", "id");
    }
}

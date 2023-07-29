<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Model;

use SwiftOtter\CustomerCollection\Api\Data\CollectionItemInterface;
use Magento\Framework\Model\AbstractModel;
use SwiftOtter\CustomerCollection\Model\ResourceModel\CollectionItem as CollectionItemResource;

class CollectionItem extends AbstractModel  implements CollectionItemInterface
{
    public const KEY_PRODUCT_ID = "product_id";
    public const KEY_CUSTOMER_ID = "customer_id";
    public const KEY_COMMENT = "comment";
    public const KEY_CREATED_AT = "created_at";
    public const KEY_UPDATED_AT = "updated_at";

    protected function _construct(
    ){
        $this->_init(CollectionItemResource::class);
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->_getData(self::KEY_PRODUCT_ID);
    }
    /**
     * @param string $product_id
     * @return CollectionItem
     */
    public function setProductId(string $product_id): CollectionItem
    {
        return $this->setData(self::KEY_PRODUCT_ID, $product_id);
    }

    /**
     * @return string
     */
    public function getCustomerId(): string
    {
        return $this->_getData(self::KEY_CUSTOMER_ID);
    }

    /**
     * @param string $customer_id
     * @return CollectionItem
     */
    public function setCustomerId(string $customer_id): CollectionItem
    {
        return $this->setData(self::KEY_CUSTOMER_ID, $customer_id);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->_getData(self::KEY_CREATED_AT);
    }

    /**
     * @param string $date
     * @return CollectionItem
     */
    public function setCreatedAt(string $date): CollectionItem
    {
        return $this->setData(self::KEY_CREATED_AT, $date);
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->_getData(self::KEY_UPDATED_AT);
    }

    /**
     * @param string $date
     * @return CollectionItem
     */
    public function setUpdatedAt(string $date): CollectionItem
    {
        return $this->setData(self::KEY_UPDATED_AT, $date);
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->_getData(self::KEY_COMMENT);
    }

    /**
     * @param string $comment
     * @return CollectionItem
     */
    public function setComment(string $comment): CollectionItem
    {
        return $this->setData(self::KEY_COMMENT, $comment);
    }
}

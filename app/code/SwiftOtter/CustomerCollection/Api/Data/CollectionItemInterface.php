<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

namespace SwiftOtter\CustomerCollection\Api\Data;

use SwiftOtter\CustomerCollection\Model\CollectionItem;

interface CollectionItemInterface
{
    public function getProductId(): string;
    public function setProductId(string $product_id): CollectionItem;
    public function getCustomerId(): string;
    public function setCustomerId(string $customer_id): CollectionItem;
    public function getCreatedAt(): string;
    public function setCreatedAt(string $date): CollectionItem;
    public function getUpdatedAt(): string;
    public function setUpdatedAt(string $date): CollectionItem;
    public function getComment(): string;
    public function setComment(string $comment): CollectionItem;
}

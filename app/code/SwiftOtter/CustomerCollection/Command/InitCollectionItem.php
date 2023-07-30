<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */
declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Command;

use SwiftOtter\CustomerCollection\Api\Data\CollectionItemInterfaceFactory;
use SwiftOtter\CustomerCollection\Api\Data\CollectionItemInterface;
use SwiftOtter\CustomerCollection\Model\CollectionItem;
use Magento\Customer\Model\Session;

class InitCollectionItem
{
    /**
     * @var CollectionItemInterfaceFactory
     */
    private CollectionItemInterfaceFactory $collectionItemFactory;
    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @param CollectionItemInterfaceFactory $collectionItemFactory
     * @param Session $customerSession
     */
    public function __construct(
        CollectionItemInterfaceFactory $collectionItemFactory,
        Session $customerSession
    ){
        $this->collectionItemFactory = $collectionItemFactory;
        $this->customerSession = $customerSession;
    }
    /**
     * @param array $data
     * @return CollectionItemInterface
     */
    public function execute(array $data): CollectionItemInterface
    {
        /** @var CollectionItem $collectionItem */
        $collectionItem = $this->collectionItemFactory->create();

        $collectionItem->setCustomerId((string) $this->customerSession->getId());
        $collectionItem->setProductId($data["product_id"]);
        $collectionItem->setComment($data["comment"]);

        return $collectionItem;
    }
}

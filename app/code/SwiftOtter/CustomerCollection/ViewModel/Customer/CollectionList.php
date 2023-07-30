<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */
declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\ViewModel\Customer;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use SwiftOtter\CustomerCollection\Model\CachedProductsLoader;
use SwiftOtter\CustomerCollection\Model\CachedProductsLoaderFactory;
use SwiftOtter\CustomerCollection\Model\ResourceModel\CollectionItem\Collection;
use SwiftOtter\CustomerCollection\Model\ResourceModel\CollectionItem\CollectionFactory as CollectionItemCollectionFactory;
use Magento\Customer\Model\Session;

class CollectionList implements ArgumentInterface
{
    /**
     * @var array|null
     */
    private ?array $collectionItems = null;
    /**
     * @var CachedProductsLoader|null
     */
    private ?CachedProductsLoader $productsLoader = null;
    /**
     * @var CachedProductsLoaderFactory
     */
    private CachedProductsLoaderFactory $cachedProductsLoaderFactory;
    /**
     * @var CollectionItemCollectionFactory
     */
    private CollectionItemCollectionFactory $collectionItemCollectionFactory;
    /**
     * @var Session
     */
    private Session $customerSession;

    /**
     * @param CachedProductsLoaderFactory $cachedProductsLoaderFactory
     * @param CollectionItemCollectionFactory $collectionItemCollectionFactory
     * @param Session $customerSession
     */
    public function __construct(
        CachedProductsLoaderFactory $cachedProductsLoaderFactory,
        CollectionItemCollectionFactory $collectionItemCollectionFactory,
        Session $customerSession
    ) {
        $this->cachedProductsLoaderFactory = $cachedProductsLoaderFactory;
        $this->collectionItemCollectionFactory = $collectionItemCollectionFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @return array
     */
    public function getCollectionItems(): array
    {
        if ($this->collectionItems === null) {
            /** @var Collection $collectionItemCollection */
            $collectionItemCollection = $this->collectionItemCollectionFactory->create();
            $collectionItemCollection->addUserToFilter((string)$this->customerSession->getId());
            $this->collectionItems = $collectionItemCollection->getItems();

            foreach($this->collectionItems as $item){
                $item["product"] = $this->getProduct($item->getProductId());
            }
        }

        return $this->collectionItems;
    }

    /**
     * @param $productId
     * @return ProductInterface|null
     */
    public function getProduct($productId): ?ProductInterface
    {
        $this->initProducts();
        return $this->productsLoader->getProduct($productId);
    }

    /**
     * @return void
     */
    public function initProducts(): void
    {
        if ($this->productsLoader !== null) {
            return;
        }

        $collectionItems = $this->getCollectionItems();
        $productIds = [];
        foreach ($collectionItems as $collectionItem) {
            if ($collectionItem->hasData('product_id')) {
                $productIds[] = $collectionItem->getData('product_id');
            }
        }

        /** @var CachedProductsLoader productsLoader */
        $this->productsLoader = $this->cachedProductsLoaderFactory->create();
        $this->productsLoader->init($productIds);
    }
}

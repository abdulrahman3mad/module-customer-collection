<?php

declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Command;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\AuthorizationException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use SwiftOtter\CustomerCollection\Api\Data\CollectionItemInterface;
class ValidateCollectionItem
{
    private const KEY_COMMENT = "comment";
    private const KEY_PRODUCT_ID = "product_id";
    private const KEY_CUSTOMER_ID = "customer_id";
    private const PUBLIC_DATA = [self::KEY_COMMENT];

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var ProductRepository
     */
    private ProductRepository $productRepository;
    /**
     * @param LoggerInterface $logger
     * @param ProductRepository $productRepository
     */
    public function __construct(
        LoggerInterface $logger,
        ProductRepository $productRepository
    ){
        $this->logger = $logger;
        $this->productRepository = $productRepository;
    }

    /**
     * @param CollectionItemInterface $collectionItem
     * @return void
     * @throws AuthorizationException
     * @throws InputException
     * @throws NoSuchEntityException
     */
    public function execute(CollectionItemInterface $collectionItem): bool
    {
        $errors = [];
        foreach(self::PUBLIC_DATA as $field){
            if(!$collectionItem->getData($field)){
                $errors[] = $field;
            }
        }

        if(!empty($errors)){
            $this->logger->error(implode(", ", $errors) . "fields are empty");
            throw new InputException(__("These fields [%1] shouldn't be empty", implode(", ", $errors)));
        }

        if(!$collectionItem->getCustomerId()){
            $this->logger->error("Not logged in user is trying to add products to collections!");
            throw new AuthorizationException(__("You must be logged in to have collections"));
        }

        if(!$this->getProduct($collectionItem)){
            $this->logger->error("The relevant product entity not found");
            throw new NoSuchEntityException();
        }

        return true;
    }

    /**
     * @param CollectionItemInterface $collectionItem
     * @return bool
     */
    public function getProduct(CollectionItemInterface $collectionItem): bool
    {
        $product = $this->productRepository->getById((string)$collectionItem->getProductId());
        return true;
    }
}

<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */

declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Model;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class CachedProductsLoader
{
    /**
     * @var array|null
     */
    private ?array $products = null;
    /**
     * @var ProductRepositoryInterface
     */
    private ProductRepositoryInterface $productRepository;
    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;
    /**
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * @param array $productIds
     * @return void
     */
    public function init(array $productIds): void
    {
        if ($this->products !== null) {
            return;
        }

        $this->searchCriteriaBuilder->addFilter('entity_id', $productIds, 'in');
        $this->products = $this->productRepository->getList($this->searchCriteriaBuilder->create())->getItems();
    }

    /**
     * @param string|int $productId
     */
    public function getProduct($productId): ?ProductInterface
    {
        return $this->products[$productId] ?? null;
    }
}

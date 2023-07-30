<?php
/**
 * @category    SwiftOtter
 * @author      Abdelrahman Emad <abdulrahman3mad@gmail.com
 * @license     http://opensource.org/licenses/OSL-3.0 The Open Software License 3.0 (OSL-3.0)
 */
declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\ViewModel\Product\View;

use Magento\Catalog\Model\Product;
use Magento\Customer\Model\Context as CustomerContext;
use Magento\Framework\Registry;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Http\Context;

class CollectionAdd implements ArgumentInterface
{
    /**
     * @var Product|null
     */
    private ?Product $product = null;
    /**
     * @var Registry
     */
    private Registry $coreRegistry;
    /**
     * @var UrlInterface
     */
    private UrlInterface $url;
    /**
     * @var Context
     */
    private Context $httpContext;

    /**
     * @param Registry $coreRegistry
     * @param UrlInterface $url
     * @param Context $httpContext
     */
    public function __construct(
        Registry $coreRegistry,
        UrlInterface $url,
        Context $httpContext
    ) {
        $this->coreRegistry = $coreRegistry;
        $this->url = $url;
        $this->httpContext = $httpContext;
    }

    /**
     * @return bool
     */
    public function customerIsLoggedIn(): bool
    {
        return (bool) $this->httpContext->getValue(CustomerContext::CONTEXT_AUTH);
    }

    /**
     * @return string
     */
    public function getActionUrl(): string
    {
        return $this->url->getUrl('mycollection/item/add');
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        $product = $this->getProduct();
        return ($product !== null) ? (string) $product->getId() : '';
    }
    /**
     * @return Product|null
     */
    private function getProduct(): ?Product
    {
        if ($this->product === null) {
            $this->product = $this->coreRegistry->registry('product');
        }
        return $this->product;
    }
}

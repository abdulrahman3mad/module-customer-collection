<?php
declare(strict_types=1);

namespace SwiftOtter\CustomerCollection\Controller\Item;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Response\RedirectInterface;
use Magento\Framework\App\ActionInterface;
use SwiftOtter\CustomerCollection\Command\InitCollectionItem;
use SwiftOtter\CustomerCollection\Command\ValidateCollectionItem;
use SwiftOtter\CustomerCollection\Model\CollectionItem;
use SwiftOtter\CustomerCollection\Model\ResourceModel\CollectionItem as CollectionItemResource;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Framework\Message\Manager;

class Add implements ActionInterface, HttpPostActionInterface
{
    /**
     * @var CollectionItem
     */
    private CollectionItem $collectionItem;
    /**
     * @var CollectionItemResource
     */
    private CollectionItemResource $collectionItemResource;
    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;
    /**
     * @var RedirectInterface
     */
    private RedirectInterface $redirect;
    /**
     * @var InitCollectionItem
     */
    private InitCollectionItem $initCollectionItem;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    /**
     * @var ValidateCollectionItem
     */
    private ValidateCollectionItem $validateCollectionItem;
    /**
     * @var Validator
     */
    private Validator $validator;
    /**
     * @var Manager
     */
    private Manager $messageManager;

    /**
     * @param CollectionItem $collectionItem
     * @param CollectionItemResource $collectionItemResource
     * @param RedirectFactory $redirectFactory
     * @param RedirectInterface $redirect
     * @param InitCollectionItem $initCollectionItem
     * @param RequestInterface $request
     * @param ValidateCollectionItem $validateCollectionItem
     * @param Validator $validator
     * @param Manager $messageManager
     */
    public function __construct(
        CollectionItem $collectionItem,
        CollectionItemResource $collectionItemResource,
        RedirectFactory $redirectFactory,
        RedirectInterface $redirect,
        InitCollectionItem $initCollectionItem,
        RequestInterface $request,
        ValidateCollectionItem $validateCollectionItem,
        Validator $validator,
        Manager $messageManager
    ){
        $this->collectionItem = $collectionItem;
        $this->collectionItemResource = $collectionItemResource;
        $this->redirectFactory = $redirectFactory;
        $this->redirect = $redirect;
        $this->initCollectionItem = $initCollectionItem;
        $this->request = $request;
        $this->validateCollectionItem = $validateCollectionItem;
        $this->validator = $validator;
        $this->messageManager = $messageManager;
    }

    public function execute()
    {
        /** @var Magento\Framework\Controller\Result\Redirect; $redirectResult */
        $data = $this->request->getParams();
        try {
            $collectionItem = $this->initCollectionItem->execute($data);
            if($this->validateCollectionItem->execute($collectionItem) &&  $this->validator->validate($this->request)){
                $this->collectionItemResource->save($collectionItem);
                $this->messageManager->addSuccessMessage("This product is added to your collections successfully");
            }
        } catch(\Exception $exception){
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        $redirectResult = $this->redirectFactory->create();
        $redirectResult->setUrl($this->redirect->getRefererUrl());
        return $redirectResult;
    }
}

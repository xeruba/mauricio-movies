<?php

namespace Mauricio\Movies\Controller\Favorite;

use Exception;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\View\Result\PageFactory;
use Mauricio\Movies\Model\FavoriteFactory;
use Mauricio\Movies\Model\ResourceModel\Favorite\CollectionFactory as FavoriteCollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\ResultFactory;

class Create extends Action
{
    /**
     * @var PageFactory
     */
    protected $_pageFactory;

    /**
     * @var FavoriteFactory
     */
    protected $_favoriteFactory;

    /**
     * @var Session
     */
    protected $_customerSession;

    /**
     * @var ManagerInterface
     */
    protected $_messageManager;

    /**
     * @var FavoriteCollectionFactory
     */
    protected $_favoriteCollectionFactory;

    /**
     * Create constructor.
     * @param Context $context
     * @param PageFactory $pageFactory
     * @param FavoriteFactory $favoriteFactory
     * @param Session $customerSession
     * @param ManagerInterface $messageManager
     * @param FavoriteCollectionFactory $favoriteCollectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $pageFactory,
        FavoriteFactory $favoriteFactory,
        Session $customerSession,
        ManagerInterface $messageManager,
        FavoriteCollectionFactory $favoriteCollectionFactory
    ) {
        $this->_pageFactory = $pageFactory;
        $this->_favoriteFactory = $favoriteFactory;
        $this->_customerSession = $customerSession;
        $this->_messageManager = $messageManager;
        $this->_favoriteCollectionFactory = $favoriteCollectionFactory;
        return parent::__construct($context);
    }

    /**
     * @return ResponseInterface|ResultInterface
     * Used to insert a new register on the table mauricio_movies_favorites
     */
    public function execute()
    {
        /* Verify that a user is authenticated */
        if (!$this->_customerSession->isLoggedIn()) {
            $this->_messageManager->addErrorMessage('You have to be logged in to favorite a movie!');
        } else {
            $customer_id = $this->_customerSession->getCustomerId();
            $product_id = $this->getRequest()->getParam('product_id');

            try {
                $favorite = $this->_favoriteFactory->create();
                $favorite->setCustomerId($customer_id);
                $favorite->setProductId($product_id);
                $favorite->save();
                $this->_messageManager->addSuccessMessage("Favorite movie saved!");
            } catch (AlreadyExistsException $e) {
                /*
                 * Handle the already a favorited movies exception
                 * */
                $this->_messageManager->addSuccessMessage('This film was already one of your favorites.');
            } catch (Exception $e) {
                /*
                 * A Catch clause to handle all the other exceptions
                 * */
                $this->_messageManager->addErrorMessage($e->getMessage());
            }
        }

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setUrl($this->_redirect->getRefererUrl());
        return $resultRedirect;
    }

}

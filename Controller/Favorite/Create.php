<?php
namespace Mauricio\Movies\Controller\Favorite;

use Mauricio\Movies\Model\FavoriteFactory;
use Mauricio\Movies\Model\ResourceModel\Favorite\CollectionFactory as FavoriteCollectionFactory;
use Magento\Customer\Model\Session;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Controller\ResultFactory;


class Create extends \Magento\Framework\App\Action\Action
{

	protected $_pageFactory;

	protected $_favoriteFactory;

	protected $_customerSession;

	protected $_messageManager;

	protected $_favoriteCollectionFactory;

    /**
     * Create constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param FavoriteFactory $favoriteFactory
     * @param Session $customerSession
     * @param ManagerInterface $messageManager
     * @param FavoriteCollectionFactory $favoriteCollectionFactory
     */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
        FavoriteFactory $favoriteFactory,
        Session $customerSession,
        ManagerInterface $messageManager,
        FavoriteCollectionFactory $favoriteCollectionFactory
		)
	{
		$this->_pageFactory = $pageFactory;
		$this->_favoriteFactory = $favoriteFactory;
		$this->_customerSession = $customerSession;
		$this->_messageManager = $messageManager;
		$this->_favoriteCollectionFactory = $favoriteCollectionFactory;
		return parent::__construct($context);
	}

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * Used to insert a new register on the table mauricio_movies_favorites
     */
	public function execute()
	{
	    /*
	     * Verify that a user is authenticated
	     * */
        if(!$this->_customerSession->isLoggedIn()){
             $this->_messageManager->addErrorMessage('You have to be logged in to favorite a movie!');
        }else{
            $customer_id = $this->_customerSession->getCustomerId();
            $product_id = $this->getRequest()->getParam('product_id');


            try {
                $favorite = $this->_favoriteFactory->create();
                $favorite->setCustomerId($customer_id);
                $favorite->setProductId($product_id);
                $favorite->save();
                $this->_messageManager->addSuccessMessage("Favorite movie saved!");
            } catch (\Magento\Framework\Exception\AlreadyExistsException $e){
                /*
                 * Handle the already a favorited movies exception
                 * */
                $this->_messageManager->addSuccessMessage('This film was already one of your favorites.');
            } catch (\Exception $e){
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

<?php
namespace Mauricio\Movies\Controller\Adminhtml\Favorite;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action\Context;

use Mauricio\Movies\Model\FavoriteFactory;


/**
 * Class Index
 * @package Mauricio\Movies\Controller\Adminhtml
 */
class Index extends Action
{
    const ACTION_RESOURCE = 'Mauricio_Movies::movies_favorite';

    /**
     * @var
     */
	protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
		Context $context,
		PageFactory $resultPageFactory
	) {
		parent::__construct($context);
		$this->resultPageFactory = $resultPageFactory;
	}

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     * Presents the index top 10 most favorites movies
     */
	public function execute()
	{
		$resultPage = $this->resultPageFactory->create();
		$resultPage->setActiveMenu(static::ACTION_RESOURCE);
		$resultPage->getConfig()->getTitle()->prepend(__('Favorite'));

		return $resultPage;
	}

}

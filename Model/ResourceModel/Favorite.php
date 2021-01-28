<?php
namespace Mauricio\Movies\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Favorite extends AbstractDb
{
    /**
     * Post constructor.
     * @param Context $context
     */
	public function __construct(
		 Context $context
	)
	{
		parent::__construct($context);
	}

	protected function _construct()
	{
		$this->_init('mauricio_movies_favorites', 'entity_id');
	}

}

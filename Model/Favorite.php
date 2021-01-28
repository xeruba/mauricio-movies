<?php
namespace Mauricio\Movies\Model;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Api\ExtensibleDataInterface;

class Favorite extends AbstractModel implements ExtensibleDataInterface
{
	const CACHE_TAG = 'mauricio_movies_favorites';

	protected $_cacheTag = 'mauricio_movies_favorites';

	protected $_eventPrefix = 'mauricio_movies_favorites';

	protected function _construct()
	{
		$this->_init('Mauricio\Movies\Model\ResourceModel\Favorite');
	}

    /**
     * @return int
     */
	public function getEntityId()
    {
        return (int) $this->getData('entity_id');
    }

    /**
     * @param int $entityId
     * @return Favorite
     */
    public function setEntityId($entityId)
    {
        return $this->setData('entity_id', $entityId);
    }

    /**
     * @return int
     * Return the product_id column
     */
    public function getProductId()
    {
        return (int) $this->getData('product_id');
    }

    /**
     * @param $productId
     * @return Favorite
     *  Set product_id on the model
     */
    public function setProductId($productId)
    {
        return $this->setData('product_id', $productId);
    }

    /**
     * @return int
     * Return the product_id column
     */
    public function getCustomerId()
    {
        return (int) $this->getData('customer_id');
    }

    /**
     * @param $customerId
     * @return Favorite
     * Set customer_id on the model
     */
    public function setCustomerId($customerId)
    {
        return $this->setData('customer_id', $customerId);
    }

}

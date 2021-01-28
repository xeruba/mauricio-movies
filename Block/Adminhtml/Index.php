<?php
namespace Mauricio\Movies\Block\Adminhtml;

use Mauricio\Movies\Service\MoviesServiceApi;

/**
 * Class Index
 * @package Mauricio\Movies\Block\Adminhtml
 */
class Index extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey
     */
    protected $formKey;

    /**
     * @var MoviesServiceApi
     */
    protected $_registry;

    /**
     * Index constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\Data\Form\FormKey $formKey
     * @param MoviesServiceApi $api
     */
	public function __construct(
	    \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Data\Form\FormKey $formKey,
        \Magento\Framework\Registry $registry
        )
	{
		parent::__construct($context);
        $this->formKey = $formKey;
        $this->_registry = $registry;
	}

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * Return the formKey
     */
	public function getFormKey(){
	    return $this->formKey->getFormKey();
    }
}

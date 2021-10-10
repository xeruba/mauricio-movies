<?php

namespace Mauricio\Movies\Block\Adminhtml;

use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Mauricio\Movies\Service\MoviesServiceApi;

/**
 * Class Index
 * @package Mauricio\Movies\Block\Adminhtml
 */
class Index extends Template
{
    /**
     * @var FormKey
     */
    protected $formKey;

    /**
     * @var MoviesServiceApi
     */
    protected $_registry;

    /**
     * Index constructor.
     * @param Context $context
     * @param FormKey $formKey
     * @param MoviesServiceApi $api
     */
    public function __construct(
        Context $context,
        FormKey $formKey,
        Registry $registry
    ) {
        parent::__construct($context);
        $this->formKey = $formKey;
        $this->_registry = $registry;
    }

    /**
     * @return string
     * @throws LocalizedException
     * Return the formKey
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }
}

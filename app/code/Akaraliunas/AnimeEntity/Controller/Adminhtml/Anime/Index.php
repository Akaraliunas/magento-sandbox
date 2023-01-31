<?php

namespace Akaraliunas\AnimeEAV\Controller\Adminhtml\Anime;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Akaraliunas_AnimeEAV::Anime');
    }
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Akaraliunas_AnimeEAV::Anime');
        $resultPage->getConfig()->getTitle()->prepend(__('Anime'));
        return $resultPage;
    }
}

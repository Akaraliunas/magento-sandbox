<?php

namespace Akaraliunas\AnimeEAV\Controller\Adminhtml\Anime;

use Akaraliunas\AnimeEAV\Model\AnimeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

// TODO
class Delete extends Action
{
    protected $animeFactory;
    public function __construct(
        Context $context,
        AnimeFactory $animeFactory
    ) {
        $this->animeFactory = $animeFactory;
        parent::__construct($context);
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Akaraliunas_AnimeEAV::Anime');
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);
        try {
            $animeData = $this->animeFactory->create()->load($id);
            if ($animeData->getId()) {
                $animeData->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the anime.'));
            } else {
                $this->messageManager->addErrorMessage(__('Anime does not exist.'));
            }
        } catch (\Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        return $resultRedirect->setPath('*/*');
    }
}

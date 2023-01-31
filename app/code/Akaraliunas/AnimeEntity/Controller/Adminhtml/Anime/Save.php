<?php

namespace Akaraliunas\AnimeEAV\Controller\Adminhtml\Anime;

use Akaraliunas\AnimeEAV\Model\AnimeFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

class Save extends Action
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
        $storeId = (int)$this->getRequest()->getParam('store_id');
        $data = $this->getRequest()->getParams();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $animeData = $this->animeFactory->create();
            $animeData->setStoreId($storeId);
            $params['store'] = $storeId;
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            } else {
                $animeData->load($data['entity_id']);
                $params['entity_id'] = $data['entity_id'];
            }
            $animeData->addData($data);
            $this->_eventManager->dispatch(
                'Akaraliunas_animeeav_prepare_save',
                ['object' => $this->animeFactory, 'request' => $this->getRequest()]
            );
            try {
                $animeData->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params['entity_id'] = $animeData->getId();
                    $params['_current'] = true;
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
            }
            $this->_getSession()->setFormData($this->getRequest()->getPostValue());
            return $resultRedirect->setPath('*/*/edit', $params);
        }
        return $resultRedirect->setPath('*/*/');
    }
}

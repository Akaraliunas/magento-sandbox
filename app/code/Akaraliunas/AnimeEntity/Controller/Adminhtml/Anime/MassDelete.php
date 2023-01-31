<?php

namespace Akaraliunas\AnimeEAV\Controller\Adminhtml\Anime;

use Akaraliunas\AnimeEAV\Model\ResourceModel\Anime\Collection;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{    protected $filter;
    protected $animeCollection;
    public function __construct(Context $context, Filter $filter, Collection $animeCollection)
    {
        $this->filter = $filter;
        $this->animeCollection = $animeCollection;
        parent::__construct($context); }
    public function execute()
    {
        $collection = $this->filter->getCollection($this->animeCollection);
        $collectionSize = $collection->getSize();
        $collection->walk('delete');
        $this->messageManager->addSuccessMessage(__('A total of %1 record(s) have been deleted.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}

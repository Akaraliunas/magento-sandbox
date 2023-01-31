<?php

namespace Akaraliunas\AnimeEAV\Block\Adminhtml\Anime\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class BackButton implements ButtonProviderInterface
{

    /* Back button
    * @param Context $context [description]
    */
    public function __construct(Context $context)
    {
        $this->urlBuilder = $context->getUrlBuilder();
    }

    public function getButtonData(): array
    {
        return
            [
                'label' => __('Back'),
                'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
                'class' => 'back',
                'sort_order' => 10
            ];
    }

    public function getBackUrl(): string
    {
        return $this->urlBuilder->getUrl('*/*/');
    }
}

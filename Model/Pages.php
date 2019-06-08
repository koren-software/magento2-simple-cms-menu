<?php
/**
 * Koren Software
 *
 * @package    Koren_SimpleCmsMenu
 * @author     Koren Software
 * @copyright  Copyright (c) 2019 Koren Software. ( https://koren.ee )
 * @license    MIT
 */

namespace Koren\SimpleCmsMenu\Model;

class Pages implements \Magento\Framework\Option\ArrayInterface
{
    protected $pageFactory;

    public function __construct(
        \Magento\Cms\Model\PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
    }

    public function toOptionArray()
    {
        $pages = [];
        $pageFactory = $this->pageFactory->create();
        $pagesCollection = $pageFactory->getCollection();
        
        if (count($pagesCollection) > 0) {
            foreach ($pagesCollection as $page) {
                $pages[] = [
                    'value' => $page->getId(),
                    'label' => $page->getTitle()
                ];
            }
        }

        return $pages;
    }
}

<?php
/**
 * Koren Software
 *
 * @package    Koren_SimpleCmsMenu
 * @author     Koren Software
 * @copyright  Copyright (c) 2019 Koren Software. ( https://koren.ee )
 * @license    MIT
 */

namespace Koren\SimpleCmsMenu\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class Menu extends Template implements BlockInterface
{
    /**
     * Path to template file in theme.
     *
     * @var string
     */

    // phpcs:disable PSR2.Classes.PropertyDeclaration
    protected $_template = "menu.phtml";

    protected $pageRepository;
    protected $currentPage;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\PageRepository $pageRepository,
        \Magento\Cms\Model\Page $currentPage
    ) {
    
        $this->pageRepository = $pageRepository;
        $this->currentPage = $currentPage;
        return parent::__construct($context);
    }

    protected function getPageIds()
    {
        return (array)explode(',', $this->getData('pages'));
    }

    public function getPages()
    {
        $pageIds = $this->getPageIds();

        $pages = [];
        if (count($pageIds) > 0) {
            foreach ($pageIds as $pageId) {
                try {
                    $page = $this->pageRepository->getById($pageId);

                    // Set if is active
                    $page->setIsActive($this->currentPage->getId() === $page->getId());

                    $pages[] = $page;
                } catch (\Exception $e) {
                    // Do nothing
                }
            }
        }

        return $pages;
    }

    // phpcs:disable PSR2.Methods.MethodDeclaration
    protected function _toHtml()
    {
        // If is not one of selected pages
        if (!in_array($this->currentPage->getId(), $this->getPageIds())) {
            return;
        }

        return parent::_toHtml();
    }
}

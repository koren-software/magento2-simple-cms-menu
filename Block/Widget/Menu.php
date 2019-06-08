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

/**
 * Menu Widget
 */
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

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Cms\Model\PageRepository $pageRepository
     * @param \Magento\Cms\Model\Page $currentPage
     * @param \Koren\SimpleCmsMenu\Helper\Data $helper
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Cms\Model\PageRepository $pageRepository,
        \Magento\Cms\Model\Page $currentPage,
        \Koren\SimpleCmsMenu\Helper\Data $helper
    ) {
        $this->pageRepository = $pageRepository;
        $this->currentPage = $currentPage;
        $this->helper = $helper;
        return parent::__construct($context);
    }

    /**
     * Get selected page IDs
     *
     * @return array
     */
    protected function getPageIds()
    {
        return (array)explode(',', $this->getData('pages'));
    }

    /**
     * Get pages
     *
     * @return array
     */
    public function getPages()
    {
        $pageIds = $this->getPageIds();

        $pages = [];
        if (!empty($pageIds)) {
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

    /**
     * Widget HTML
     *
     * @return void
     *
     * phpcs:disable PSR2.Methods.MethodDeclaration
     */
    protected function _toHtml()
    {
        // If is not one of selected pages
        // Must be enabled
        // Check if needs to show only on selected pages
        if (!$this->helper->isEnabled() ||
            (
                $this->helper->showOnlyOnSelected() &&
                !in_array($this->currentPage->getId(), $this->getPageIds())
            )
        ) {
            return;
        }

        return parent::_toHtml();
    }
}

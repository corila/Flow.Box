<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\Page;

class BackendController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\PageRepository
	 */
	protected $pageRepository;

	/**
	 * @return void
	 */
	public function pageAction() {
		$this->view->assign('pages', $this->pageRepository->findAll());
	}

	/**
	 * @return void
	 */
	public function newPageAction() {
		
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $newPage
	 * @return void
	 */
	public function createPageAction(Page $newPage) {
		$this->pageRepository->add($newPage);
		$this->addFlashMessage('Created a new page.');
		$this->redirect('page');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $page
	 * @return void
	 */
	public function editPageAction(Page $page) {
		$this->view->assign('page', $page);
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $page
	 * @return void
	 */
	public function updatePageAction(Page $page) {
		$this->pageRepository->update($page);
		$this->addFlashMessage('Updated the page.');
		$this->redirect('index');
	}
}

?>
<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\Page;

class PageController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\PageRepository
	 */
	protected $pageRepository;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('pages', $this->pageRepository->findAll());
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $page
	 * @return void
	 */
	public function showAction(Page $page) {
		$this->view->assign('page', $page);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $newPage
	 * @return void
	 */
	public function createAction(Page $newPage) {
		$this->pageRepository->add($newPage);
		$this->addFlashMessage('Created a new page.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $page
	 * @return void
	 */
	public function editAction(Page $page) {
		$this->view->assign('page', $page);
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $page
	 * @return void
	 */
	public function updateAction(Page $page) {
		$this->pageRepository->update($page);
		$this->addFlashMessage('Updated the page.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Page $page
	 * @return void
	 */
	public function deleteAction(Page $page) {
		$this->pageRepository->remove($page);
		$this->addFlashMessage('Deleted a page.');
		$this->redirect('index');
	}

}

?>
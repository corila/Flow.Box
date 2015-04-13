<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\Label;

class LabelController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\LabelRepository
	 */
	protected $labelRepository;

	/**
	 *
	 * @param string $title
	 * @return void
	 */
	public function indexAction($title = NULL) {
		if (!empty($title)) {
			$this->view->assign('labels', $this->labelRepository->findByOptions($title));
			$this->view->assign('title', $title);
		} else {
			$this->view->assign('labels', $this->labelRepository->findAll());
		}
	}

	/**
	 * @param \Flow\Box\Domain\Model\Label $label
	 * @return void
	 */
	public function showAction(Label $label) {
		$this->view->assign('label', $label);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param \Flow\Box\Domain\Model\Label $newLabel
	 * @return void
	 */
	public function createAction(Label $newLabel) {
		$this->labelRepository->add($newLabel);
		$this->addFlashMessage('Created a new label.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Label $label
	 * @return void
	 */
	public function editAction(Label $label) {
		$this->view->assign('label', $label);
	}

	/**
	 * @param \Flow\Box\Domain\Model\Label $label
	 * @return void
	 */
	public function updateAction(Label $label) {
		$this->labelRepository->update($label);
		$this->addFlashMessage('Updated the label.');
		if($this->securityContext->hasRole('Flow.Box:SupperAdmin')) {
			$this->redirect('index');
		} else {
			$this->redirect('index', 'dashboard');
		}
	}

	/**
	 * @param \Flow\Box\Domain\Model\Label $label
	 * @return void
	 */
	public function deleteAction(Label $label) {
		$this->labelRepository->remove($label);
		$this->addFlashMessage('Deleted a label.');
		$this->redirect('index');
	}

	/**
	 * @param array $sortingIdentities Identities in soring order
	 * @return boolean
	 */
	public function updateSortingAction(array $sortingIdentities = NULL) {
		foreach ($sortingIdentities as $key => $recordIDValue) {
			$item = $this->labelRepository->findByIdentifier($recordIDValue);
			if ($item) {
				$item->setSorting($key);
				$this->labelRepository->update($item);
			}
		}

		return TRUE;
	}

}
<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\Seed;

class SeedController extends ActionController implements DragDropInterface {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\SeedRepository
	 */
	protected $seedRepository;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('seeds', $this->seedRepository->findMainSeeds());
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $seed
	 * @return void
	 */
	public function showAction(Seed $seed) {
		$childSeeds = $this->seedRepository->findOrderByParent($seed);
		$this->view->assign('childrenSeeds', $childSeeds);
		$this->view->assign('seed', $seed);
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $seed
	 * @return void
	 */
	public function newAction(Seed $parentSeed = NULL) {
		$this->view->assign('seeds', $this->seedRepository->findAll());
		if ($parentSeed) {
			$this->view->assign('parentSeed', $parentSeed);
		}
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $newSeed
	 * @return void
	 */
	public function createAction(Seed $newSeed) {
		$newItemOrder = 0;
		$greatestOrderItem = $this->seedRepository->findGreatestOrder($newSeed->getParentSeed());
		if ($greatestOrderItem) {
			$newItemOrder = $greatestOrderItem->getOrderItem();
		}

		$newSeed->setOrderItem($newItemOrder+1);
		$this->seedRepository->add($newSeed);
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $seed
	 * @return void
	 */
	public function editAction(Seed $seed) {
		$this->view->assign('seed', $seed);
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $seed
	 * @return void
	 */
	public function updateAction(Seed $seed) {
		$this->seedRepository->update($seed);
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $seed
	 * @return void
	 */
	public function deleteAction(Seed $seed) {
		$this->seedRepository->remove($seed);
		$this->redirect('index');
	}

	/**
	 * @return void
	 */
	public function updateOrderParentAction() {
		if ($this->request->hasArgument('recordsArray')) {
			$updateRecordsArray = $this->request->getArgument('recordsArray');

			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue) {
				$item = $this->seedRepository->findOrderOfParent($recordIDValue);
				$item->setOrderItem($listingCounter);
				$this->seedRepository->update($item);
				$listingCounter = $listingCounter + 1;
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}

	/**
	 * @return void
	 */
	public function updateOrderChildAction() {
		if ($this->request->hasArgument('recordsArray')) {
			$updateRecordsArray = $this->request->getArgument('recordsArray');
			$parent = $this->request->getArgument('parent');
			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue) {
				$item = $this->seedRepository->findOrderOfChild($parent,$recordIDValue);
				\typo3\flow\var_dump($item);
				$item->setOrderItem($listingCounter);
				$this->seedRepository->update($item);
				$listingCounter = $listingCounter + 1;
			}
			$this->persistenceManager->persistAll();
			return TRUE;
		} else {
			return FALSE;
		}
	}
}

?>
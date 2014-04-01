<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\Seed;

class SeedController extends ActionController {

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
		$this->view->assign('seed', $seed);
	}

	/**
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('seeds', $this->seedRepository->findAll());
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $newSeed
	 * @return void
	 */
	public function createAction(Seed $newSeed) {
		$newItemOrder = 0;
		$greatestOrderItem = $this->seedRepository->findGreatestOrder();
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
	public function updateOrderAction() {
		if ($this->request->hasArgument('recordsArray')) {
			$updateRecordsArray = $this->request->getArgument('recordsArray');

			$listingCounter = 1;
			foreach ($updateRecordsArray as $recordIDValue) {
				$item = $this->seedRepository->findOneByOrderItem($recordIDValue);
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
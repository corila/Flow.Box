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
		$this->view->assign('seeds', $this->seedRepository->findAll());
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
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $newSeed
	 * @return void
	 */
	public function createAction(Seed $newSeed) {
		$this->seedRepository->add($newSeed);
		$this->addFlashMessage('Created a new seed.');
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
		$this->addFlashMessage('Updated the seed.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Seed $seed
	 * @return void
	 */
	public function deleteAction(Seed $seed) {
		$this->seedRepository->remove($seed);
		$this->addFlashMessage('Deleted a seed.');
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
		}
		//\typo3\flow\var_dump($updateRecordsArray);
		//die('jjjjjjjjjjj');
	}
}

?>
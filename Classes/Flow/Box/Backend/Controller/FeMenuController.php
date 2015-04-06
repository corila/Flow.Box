<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\FeMenu;
use Flow\Box\Domain\Model\Content;

class FeMenuController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\FeMenuRepository
	 */
	protected $feMenuRepository;

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\ContentRepository
	 */
	protected $contentRepository;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('feMenus', $this->feMenuRepository->findAll());
	}

	/**
	 * @param \Flow\Box\Domain\Model\FeMenu $feMenu
	 * @return void
	 */
	public function showAction(FeMenu $feMenu) {
		$this->view->assign('feMenu', $feMenu);
	}

	/**
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('availableOrders', $this->getAvailableOrders());
	}

	/**
	 * @param FeMenu $newFeMenu
	 * @param bool $type
	 * @param string $description
	 * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
	 * @return void
	 */
	public function createAction(FeMenu $newFeMenu, $type = FALSE, $description = NULL) {
		if($type) {
			$this->createOrUpdateContent($newFeMenu, $description);
		}
		$this->feMenuRepository->add($newFeMenu);
		$this->addFlashMessage('Created a new fe menu.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\FeMenu $feMenu
	 * @return void
	 */
	public function editAction(FeMenu $feMenu) {
		$content = $this->contentRepository->findByFeMenu($feMenu);
		$this->view->assign('availableOrders', $this->getAvailableOrders($feMenu->getMenuOrder()));
		$this->view->assign('feMenu', $feMenu);
		$this->view->assign('content', $content);
	}

	/**
	 * @param FeMenu $feMenu
	 * @param bool $type
	 * @param string $description
	 * @throws \TYPO3\Flow\Persistence\Exception\IllegalObjectTypeException
	 * @return void
	 */
	public function updateAction(FeMenu $feMenu, $type = FALSE, $description = NULL) {
		if($type){
			$this->createOrUpdateContent($feMenu, $description);
		} else {
			$this->removeContent($feMenu);
		}
		$this->feMenuRepository->update($feMenu);
		$this->addFlashMessage('Updated the fe menu.');
		$this->redirect('index');
	}

	/**
	 * @param FeMenu $feMenu
	 * @return void
	 */
	public function deleteAction(FeMenu $feMenu) {
		$this->removeContent($feMenu);
		$this->feMenuRepository->remove($feMenu);
		$this->addFlashMessage('Deleted a fe menu.');
		$this->redirect('index');
	}

	/**
	 * @param int $currentOrder
	 * @return array
	 */
	public function getAvailableOrders($currentOrder = 0) {
		$availableOrders = $defaultOrders =  $existOrders = array();
		$maxMenu = $this->settings['maxFeMenus'];
		$allMenu = $this->feMenuRepository->findAll();
		if ($allMenu) {
			foreach ($allMenu as $menu) {
				$existOrders[$menu->getMenuOrder()] = $menu->getMenuOrder();
			}
		}

		for ($i = 1; $i <= $maxMenu; $i++) {
			$defaultOrders[$i] = $i;
		}

		$availableOrders = array_diff($defaultOrders, $existOrders);
		if ($currentOrder > 0) {
			$availableOrders[$currentOrder] = $currentOrder;
		}
		asort($availableOrders);
		return $availableOrders;
	}

	/**
	 * @param FeMenu $feMenu
	 * @param $description
	 */
	private function createOrUpdateContent(FeMenu $feMenu, $description) {
		$content = $this->contentRepository->findByFeMenu($feMenu);
		if($content){
			$content->setDescription($description);
			$this->contentRepository->update($content);
		} else {
			$content = new Content();
			$content->setDescription($description);
			$content->setFeMenu($feMenu);
			$this->contentRepository->add($content);
		}
	}

	private function removeContent(FeMenu $feMenu) {
		$content = $this->contentRepository->findByFeMenu($feMenu);
		if($content){
			$this->contentRepository->remove($content);
			$this->persistenceManager->persistAll();
		}
	}
}
?>
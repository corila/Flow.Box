<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Flow\Box\Domain\Model\Page;

class DashboardController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\LabelRepository
	 */
	protected $labelRepository;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('labels', $this->labelRepository->findWithLimit());
	}

	/**
	 * @return void
	 */
	public function newPageAction() {
		
	}
}

?>
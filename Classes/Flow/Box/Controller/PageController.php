<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use Flow\Box\Domain\Model\Page;
use TYPO3\Flow\Error\Error;

class PageController extends MainFrontendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\LabelRepository
	 */
	protected $labelRepository;

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\ContentRepository
	 */
	protected $contentRepository;

	/**
	 * @return void
	 */
	public function indexAction() {

	}
}

?>
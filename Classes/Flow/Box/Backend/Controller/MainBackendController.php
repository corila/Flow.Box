<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

abstract class MainBackendController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Resource\ResourceManager
	 */
	protected $resourceManager;
	
	/**
	 * @var \TYPO3\Flow\Security\Account
	 */
	protected $account;

	/**
	 * @var array
	 */
	protected $activeMenu = array('Dashboard' => 1);

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Context
	 */
	protected $securityContext;


	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction() {
		//Create Action Menu
		$this->activeMenu = array($this->request->getControllerName() => 'active');

		$this->account = $this->securityContext->getAccount();
	}

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param \TYPO3\Flow\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	 * @api
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
		$view->assign('activeMenu', $this->activeMenu);
		$csrfToken = $this->securityContext->getCsrfProtectionToken();
		$view->assignMultiple(
			array(
				'activeMenu' => $this->activeMenu,
				'currentUser' => $this->account,
				'csrfToken' => $csrfToken
			)
		);

	}

	/**
	 * @param $imageResource
	 * @return \TYPO3\Flow\Resource\Resource
	 */
	protected function uploadImage($imageResource) {
		$fileResource = $this->resourceManager->importUploadedResource($imageResource);
		$uri = $fileResource->getUri();

		// read file
		$csvLines = array();
		$fHandle = \fopen($uri, 'r');
		if ($fHandle) {
			while (($buffer = \fgets($fHandle, 4096)) !== false) {
				$csvLines[] = $buffer;
			}
		}
		\fclose($fHandle);
		return $fileResource;
	}
}

?>
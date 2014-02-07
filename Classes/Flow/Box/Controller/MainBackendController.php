<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

class MainBackendController extends ActionController {
	
	/**
	 * @var \TYPO3\Flow\Security\Account
	 */
	protected $account;

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
		$this->account = $this->securityContext->getAccount();
	}

	/**
	 * Login action
	 * 
	 * @return void
	 * @throws \TYPO3\Flow\Security\Exception\AuthenticationRequiredException
	 * @throws \TYPO3\Flow\Security\Exception
	 */
	public function loginAction() {
		try {
			$this->authenticationManager->authenticate();
			$this->redirect('page');
		} catch (\TYPO3\Flow\Security\Exception $exception) {
			$this->addFlashMessage('Wrong username or password.');
			throw $exception;
		}
	}

	/**
	 * Log out funtion
	 *
	 * @return void
	 */
	public function logoutAction() {
		$this->authenticationManager->logout();
		$this->addFlashMessage('Successfully logged out.');
		$this->redirect('index');
	}

	/**
	 * @return void
	 */
	public function indexAction() {
		if (is_object($this->account)) {
			$this->redirect('page');
		}
	}

	/**
	 * @param object $object
	 * @return void
	 */
	public function deleteAction(Page $page) {
		$this->pageRepository->remove($page);
		$this->addFlashMessage('Deleted a page.');
		$this->redirect('index');
	}
}

?>
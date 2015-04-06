<?php
/**
 * Created by PhpStorm.
 * User: chanthou
 * Date: 12/15/14
 * Time: 12:41 AM
 */

namespace Flow\Box\Backend\Controller;

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Security\Authentication\AuthenticationManagerInterface;
use TYPO3\Flow\Security\Exception\AuthenticationRequiredException;
use TYPO3\Flow\Error\Error;

class LoginController extends MainBackendController {
	/**
	 * @var AuthenticationManagerInterface
	 * @Flow\Inject
	 */
	protected $authenticationManager;



	/**
	 * @return void
	 */
	public function indexAction() {
		if ($this->authenticationManager->isAuthenticated()) {
			$this->redirect('index', 'Dashboard');
		}
	}

	/**
	 * @throws AuthenticationRequiredException
	 * @return void
	 */
	public function authenticateAction() {
		try {
			$this->authenticationManager->authenticate();
			$this->redirect('index', 'Dashboard');
		} catch (AuthenticationRequiredException $exception) {
			$this->flashMessageContainer->addMessage(new Error('Wrong username or password.'));
			$this->redirect('index', 'Login');
			throw $exception;
		}
	}

	/**
	 * @return void
	 */
	public function logoutAction() {
		$this->authenticationManager->logout();
		$this->addFlashMessage('Logout success');
		$this->redirect('index', 'Login');
	}
}
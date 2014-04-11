<?php
namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the Codecoon project. All rights reserved!      *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Error\Error;
use TYPO3\Flow\Error\Notice;
use TYPO3\Flow\Mvc\ActionRequest;
use TYPO3\Flow\Security\Authentication\Controller\AbstractAuthenticationController;
use TYPO3\Flow\Security\Exception\AuthenticationRequiredException;

/**
 * A controller which allows for logging into the Codecoon Management Portal
 *
 * @Flow\Scope("singleton")
 * @codeCoverageIgnore
 */
class LoginController extends AbstractAuthenticationController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Session\SessionInterface
	 */
	protected $session;



	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\I18n\Translator
	 */
	protected $translator;



	/**
	 * @var array
	 */
	protected $viewFormatToObjectNameMap = array('json' => 'TYPO3\Flow\Mvc\View\JsonView');



	/**
	 * Default action, displays the login screen
	 *
	 * @param string $username Optional: A username to prefill into the username field
	 * @return void
	 */
	public function indexAction($username = NULL) {
		$this->view->assignMultiple(array(
				'username' => $username,
				'activeHash' => $this->request->hasArgument('activeHash') ? $this->request->getArgument('activeHash') : NULL,
				'welcomeMessage' => 'Please Login'
		));
	}



	/**
	 * Is called if authentication failed.
	 *
	 * @param AuthenticationRequiredException $exception The exception thrown while the authentication process
	 * @return void
	 */
	protected function onAuthenticationFailure(AuthenticationRequiredException $exception = NULL) {
		$this->flashMessageContainer->addMessage(new Error('Wrong username and password', ($exception === NULL ? 1347016771 : $exception->getCode())));
		$this->redirect('index');
	}



	/**
	 * Is called if authentication was successful.
	 *
	 * @param ActionRequest $originalRequest The request that was intercepted by the security framework, NULL if there was none
	 * @return void
	 */
	public function onAuthenticationSuccess(ActionRequest $originalRequest = NULL) {
		if ($originalRequest !== NULL) {
			$this->redirectToRequest($originalRequest);
		}
		$this->redirect('page', 'Backend');
	}



	/**
	 * Logs out a - possibly - currently logged in account.
	 * Before the actual logout takes place, and the session gets destroyed.
	 *
	 * @return void
	 */
	public function logoutAction() {
		parent::logoutAction();
		$this->flashMessageContainer->addMessage(new Notice('Logout success', 1318421560));
		$this->redirect('index');
	}



	/**
	 * Tranlates given translation key
	 *
	 * @param string $labelId The id if translate label
	 * @param array $arguments
	 * @return string
	 */
	private function getTranslate($labelId, array $arguments = array()) {
		return $this->translator->translateById($labelId, $arguments, NULL, NULL, 'Main', $packageKey = 'Flow.Box');
	}

}
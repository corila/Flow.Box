<?php
/**
 * Created by PhpStorm.
 * User: chanthou
 * Date: 1/30/15
 * Time: 10:38 PM
 */

namespace Flow\Box\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;

class MainFrontendController extends ActionController {


	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Session\BrowserState
	 */
	protected $browserState;

	/**
	 * @var string
	 */
	protected $activeMenu = '';

	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction() {
		//Create Action Menu

		$this->activeMenu = $this->request->getControllerActionName();
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
		$activeLanguage = array();
		$activeLanguage['km'] = ( $this->request->getArgument('language') == 'km') ? 'active' : FALSE;
		$activeLanguage['en'] = ( $this->request->getArgument('language') == 'en') ? 'active' : FALSE;

		$khmerArguments = $this->request->getArguments();
		$khmerArguments['language'] = 'km';
		$englishArguments = $this->request->getArguments();
		$englishArguments['language'] = 'en';


		$view->assignMultiple(
			array(
				'activeMenu' => $this->activeMenu,
				'khmerArguments' => $khmerArguments,
				'englishArguments' => $englishArguments,
				'activeLanguage' => $activeLanguage,
				'currentAction' => $this->request->getControllerActionName(),
			)
		);
	}


	/**
	 * @param mixed  $to
	 * @param string $subject
	 * @param string $body
	 * @param string $from
	 * @return bool
	 */
	public function sendMail($to, $subject, $body, $from = NULL) {
		$from = ! empty($from) ? $from : 'noreply@anachakh.com';
		$mail = new \TYPO3\SwiftMailer\Message();
		$mail->setFrom($from);
		$mail->setTo($to);
		$mail->setSubject($subject);
		$mail->addPart($body, 'text/html', 'utf-8');
		$mail->send();
		return $mail->isSent() ? TRUE : FALSE;
	}

	/**
	 * @param array  $arguments
	 * @param string $templateResource
	 *
	 * @return mixed
	 */
	public function renderMailTemplate($arguments = array(), $templateResource = 'resource://Flow.Box/Private/Templates/Mail/ContactTemplate.html') {
		$view = $this->objectManager->get('\TYPO3\Fluid\View\StandaloneView');
		$view->setTemplatePathAndFilename($templateResource);
		$view->assign('arguments', $arguments);
		return $view->render();
	}
}
?>
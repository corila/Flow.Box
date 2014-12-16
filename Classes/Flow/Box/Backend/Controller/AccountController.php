<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Flow\Box\Domain\Model\Account;

class AccountController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountFactory
	 */
	protected $accountFactory;
	
	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountSecurityRepository;

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Authentication\AuthenticationManagerInterface
	 */
	protected $authenticationManager;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('accounts', $this->accountRepository->findAll());
	}

	/**
	 * @param \Flow\Box\Domain\Model\Account $account
	 * @return void
	 */
	public function showAction(Account $account) {
		$this->view->assign('account', $account);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * 
	 * @param string  $firstName
	 * @param string  $lastName
	 * @param string  $email
	 * @param string  $username
	 * @param \Flow\Box\Domain\Model\Account $newAccount
	 * @Flow\IgnoreValidation("$newAccount")
	 * @return void
	 */
	public function createAction($firstName, $lastName, $email, $username, Account $newAccount) {
	try {
			$newAccount->setName(new \TYPO3\Party\Domain\Model\PersonName('', $firstName, '', $lastName));
			$electronicAddress = new \TYPO3\Party\Domain\Model\ElectronicAddress();
			$electronicAddress->setType(\TYPO3\Party\Domain\Model\ElectronicAddress::TYPE_EMAIL);
			$electronicAddress->setIdentifier($email);
			$newAccount->setPrimaryElectronicAddress($electronicAddress);
			
			$account = $this->accountFactory->createAccountWithPassword($username, $newAccount->getPassword(), array('Flow.Box:Admin'));
			$this->accountSecurityRepository->add($account);
			
			$newAccount->addAccount($account);
			$this->accountRepository->add($newAccount);
			$this->persistenceManager->persistAll();
		} catch (\PDOException $exception) {
			$this->addFlashMessage($exception->getMessage());
			$this->forward('new');
		}
		$this->addFlashMessage('Created a new account.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Account $account
	 * @return void
	 */
	public function editAction(Account $account) {
		$this->view->assign('account', $account);
	}

	/**
	 * @param \Flow\Box\Domain\Model\Account $account
	 * @return void
	 */
	public function updateAction(Account $account) {
		$this->accountRepository->update($account);
		$this->addFlashMessage('Updated the account.');
		$this->redirect('index');
	}

	/**
	 * @param \Flow\Box\Domain\Model\Account $account
	 * @return void
	 */
	public function deleteAction(Account $account) {
		$this->accountRepository->remove($account);
		$this->addFlashMessage('Deleted a account.');
		$this->redirect('index');
	}

}

?>
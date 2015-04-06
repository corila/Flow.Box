<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Flow\Box\Domain\Model\User;

class AccountController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Service\Account\UserService
	 */
	protected $userService;

	/**
	 * @return void
	 */
	public function indexAction() {
		if ($this->securityContext->hasRole('Flow.Box:SupperAdmin')) {
			$users = $this->userRepository->findAll();
		} else {
			$users = $this->userRepository->findByRole('Flow.Box:SupperAdmin', TRUE);
		}
		$this->view->assign('users', $users);
	}

	/**
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * @param User $newUser
	 * @param string $username
	 * @param string $password
	 * @param array $roles
	 *
	 * @return void
	 */
	public function createAction(User $newUser, $username, $password, $roles = array()) {
		$newUser = $this->userService->createAccount($newUser, $username, $password, $roles);
		$this->userRepository->add($newUser);
		$this->addFlashMessage('User Created');
		$this->redirect('index');
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function editAction(User $user) {
		$this->view->assign('user', $user);
	}

	/**
	 * @param User $user
	 * @param string $username
	 * @param string $password
	 * @param array $roles
	 *
	 * @return void
	 */
	public function updateAction(User $user, $username, $password, $roles = array()) {
		$user = $this->userService->updateAccount($user, $username, $password, $roles);
		$this->userRepository->update($user);
		$this->addFlashMessage('Updated the account.');

		if($this->securityContext->hasRole('Flow.Box:SupperAdmin') || $this->securityContext->hasRole('Flow.Box:SupperAdmin')) {
			$this->redirect('index');
		} else {
			$this->redirect('index', 'dashboard');
		}
	}

	/**
	 * @param User $user
	 * @return void
	 */
	public function deleteAction(User $user) {
		$accountIdentifier = $user->getAccounts();
		$this->userService->deleteAccount($accountIdentifier[0]->getAccountIdentifier());
		$this->userRepository->remove($user);
		$this->addFlashMessage('Acction Deleted');
		$this->redirect('index');
	}

}

?>
<?php

namespace Flow\Box\Domain\Service\Account;


/*                                                                        *
 * This script belongs to the TYPO3 Flow package "WE.EMS".                *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use Flow\Box\Domain\Model\User;
use TYPO3\Flow\Annotations as Flow;
use Flow\Box\Domain\Repository\UserRepository;

/**
 * A service for meeting registration
 */
class UserService {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Policy\RoleRepository
	 */
	protected $roleRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Party\Domain\Repository\PartyRepository
	 */
	protected $partyRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\Cryptography\HashService
	 */
	protected $hashService;

	/**
	 * Name of the authentication provider to be used.
	 *
	 * @var string
	 */
	protected $defaultProvider = 'DefaultProvider';

	/**
	 * Name of the authentication provider to be used.
	 *
	 * @var string
	 */
	protected $ldapProvider = 'LdapProvider';

	/**
	 * @Flow\Inject
	 * @var UserRepository
	 */
	protected $userRepository;

	/**
	 * @param User $user
	 * @param string $username
	 * @param string $password
	 * @param array $roles
	 * @return User
	 */
	public function createAccount(User $user, $username, $password, $roles = array()) {
		$account = $this->accountFactory->createAccountWithPassword($username, $password, $roles, $this->defaultProvider);
		$this->accountRepository->add($account);
		$user->addAccount($account);
		return $user;
	}

	/**
	 * @param User $user
	 * @param string $username
	 * @param string $password
	 * @param array $roles
	 * @return User
	 */
	public function updateAccount(User $user, $username, $password, $roles = array()) {
		$accountIdentifier = $user->getAccounts();
		$account = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($accountIdentifier[0]->getAccountIdentifier(), $this->defaultProvider);
		if ($account) {
			$account->setAccountIdentifier($username);
			$this->updateAccountPassword($user, $password);
			$newRoles = array();
			$newRoles[$roles[0]] = $this->roleRepository->findByIdentifier($roles[0]);
			$account->setRoles($newRoles);
			$this->accountRepository->update($account);
			$user->addAccount($account);
		}
		return $user;
	}

	/**
	 * @param string  $username
	 *
	 * @return void
	 */
	public function deleteAccount($username) {
		$account = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($username, $this->defaultProvider);
		$this->partyRepository->remove($account->getParty());
		$this->accountRepository->remove($account);

	}

	/**
	 * @param User $user
	 * @param string $password
	 *
	 * @return void
	 */
	public function updateAccountPassword(User $user, $password) {
		$accountIdentifier = $user->getAccounts();
		$account = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($accountIdentifier[0]->getAccountIdentifier(), $this->defaultProvider);
		if ($account) {
			if (!empty($password)) {
				$account->setCredentialsSource($this->hashService->hashPassword($password));
			}
			$this->accountRepository->update($account);
		}
	}

	/**
	 * @param string $username
	 * @return bool
	 */
	public function isAccountExist($username) {
		$existingAccount = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($username, $this->defaultProvider);
		if (! $existingAccount) {
			$existingAccount = $this->accountRepository->findActiveByAccountIdentifierAndAuthenticationProviderName($username, $this->ldapProvider);
		}
		return ! $existingAccount ? FALSE : TRUE;
	}

	/**
	 * @param User $user
	 * @param array $roles
	 * @return bool
	 */
	public function isUserHasRoles(User $user, $roles = array()) {
		foreach($user->getAccounts() as $account) {
			foreach($account->getRoles() as $role) {
				if(in_array($role->getIdentifier(), $roles)) {
					return TRUE;
				}
			}
		}
		return FALSE;
	}
}

?>
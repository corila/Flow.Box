<?php
namespace Flow\Box\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "WE.EMS".                *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Account command controller for the WE.EMS package
 *
 * @Flow\Scope("singleton")
 */
class AccountCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountFactory
	 */
	protected $accountFactory;

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Service\Account\UserService
	 */
	protected $userService;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Party\Domain\Repository\PartyRepository
	 */
	protected $partyRepository;

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\UserRepository
	 */
	protected $userRepository;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

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
	 * Command to create an account with default provider
	 *
	 * This command create an account as an alternative to registering through
	 * Web Interface. This is the only way at the moment to create account with
	 * admin access.
	 *
	 * Please apply the correct parameters as in the Usage and Arguments section above
	 *
	 * @param string $username The account's username
	 * @param string $password The account's password
	 * @param string $firstName The account's first name
	 * @param string $lastName The account's last name
	 * @param string $email The account's email address
	 * @param string $userType Type of user(user|admin|supper). Default is user.
	 *
	 * @return void
	 */
	public function createCommand($username, $password, $firstName, $lastName, $email, $userType = 'user') {
		// Doesn't do anything if account exists
		if ($this->userService->isAccountExist($username)) {
			$this->outputLine('FAILED: Account "' . $username . '" already exists!');
			return;
		}
		// Validate email address
		if (! $this->validEmail($email)) {
			$this->outputLine('FAILED: Please specify a valid email address.');
			return;
		}
		// Check if the email address already in use
		$userEmailExist = $this->userRepository->findOneByEmail($email);
		if ($userEmailExist) {
			$this->outputLine('FAILED: Email address "' . $email . '" already exists in the system.');
			return;
		}
		// Check for password length
		$minimumLength = 5;
		if (strlen($password) < $minimumLength) {
			$this->outputLine('FAILED: The minimum password length must be ' . $minimumLength . '.');
			return;
		}
		// Everything is fine, create an account with default provider
		$user = new \Flow\Box\Domain\Model\User();
		$user->setFirstName($firstName);
		$user->setLastName($lastName);
		$user->setEmail($email);

		$roleIdentifiers = array();
		if ($userType == 'supper') {
			$roleIdentifiers[] = 'Flow.Box:SupperAdmin';
		} elseif ($userType == 'admin') {
			$roleIdentifiers[] = 'Flow.Box:Admin';
		} else {
			$roleIdentifiers[] = 'Flow.Box:User';
		}

		$user = $this->userService->createAccount($user, $username, $password, $roleIdentifiers);
		$this->partyRepository->add($user);

		$this->outputLine('New account "%s" has been created.', array($username));
	}

	/**
	 * Command to remove an account from default provider
	 *
	 * This command remove an account from the database by searching for the username applied.
	 * Come with a confirmation message to reduce common mistake.
	 *
	 * @param string $username The account's username
	 *
	 * @return void
	 */
	public function removeCommand($username) {
		// Check if the account exists
		if (!$this->userService->isAccountExist($username)) {
			$this->outputLine('FAILED: Account "' . $username . '" does not exist!');
			return;
		}
		if ($this->confirm('Are you sure you want to remove account "' . $username . '"? (Y/n): ')) {
			try {
				$this->userService->deleteAccount($username);
				$this->outputLine('Account "%s" has been removed.', array($username));
			} catch (\Exception $exception) {
				$this->outputLine('FAILED: Account "%s" is associated with training topics and cannot be removed!', array($username));
			}
		} else {
			$this->outputLine('Aborted!');
		}
	}

	/**
	 * Command to list all accounts
	 *
	 * This command lists all accounts from the database with some useful information.
	 *
	 * @return void
	 */
	public function listCommand() {
		$users = $this->userRepository->findAll();
		foreach ($users as $user) {
			$account = $user->getAccounts();
			$this->outputLine('- ' . $account[0]->getAccountIdentifier() . ' | ' . $user->getFirstName() .
				' | ' . $user->getEmail() . ' | ' . (in_array('Flow.Box:Admin', $account[0]->getRoles()) ?
				'Admin' : 'User') . ' | ' . $account[0]->getAuthenticationProviderName());
		}
	}


	/**
	 * Checking syntax of input email address
	 *
	 * @param string $emailAddress Input string to evaluate
	 * @return boolean Returns TRUE if the $email address (input string) is valid
	 */
	private function validEmail($emailAddress) {
		// Enforce maximum length to prevent libpcre recursion crash bug #52929 in PHP
		// fixed in PHP 5.3.4; length restriction per SMTP RFC 2821
		if (strlen($emailAddress) > 320) {
			return FALSE;
		}

		return (filter_var($emailAddress, FILTER_VALIDATE_EMAIL) !== FALSE);
	}

	/**
	 * Confirm message in command line action
	 *
	 * @param string $message The message
	 *
	 * @return boolean
	 */
	private function confirm($message) {
		print($message);
		$response = (string)fgets(STDIN);
		if (strcmp(trim($response), 'Y') == 0) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>
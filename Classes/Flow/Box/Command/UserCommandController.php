<?php
namespace Flow\Box\Command;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Flow\Box\Constant\Utility;

/**
 * @Flow\Scope("singleton")
 */
class UserCommandController extends \TYPO3\Flow\Cli\CommandController {

	/**
	 * @Flow\Inject
	 * @var TYPO3\Flow\Persistence\PersistenceManagerInterface
	 */
	protected $persistenceManager;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Security\AccountRepository
	 */
	protected $accountRepository;

	/**
	 * Name of the authentication provider to be used.
	 *
	 * @var string
	 */
	protected $authenticationProviderName = 'DefaultProvider';

	/**
	 * An example command
	 *
	 * The comment of this command method is also used for TYPO3 Flow's help screens. The first line should give a very short
	 * summary about what the command does. Then, after an empty line, you should explain in more detail what the command
	 * does. You might also give some usage example.
	 *
	 * It is important to document the parameters with param tags, because that information will also appear in the help
	 * screen.
	 *
	 * @param string $requiredArgument This argument is required
	 * @param string $optionalArgument This argument is optional
	 * @return void
	 */
	public function exampleCommand($requiredArgument, $optionalArgument = NULL) {
		$this->outputLine('You called the example command and passed "%s" as the first argument.', array($requiredArgument));
	}

	/**
	 * Lists all roles of the specified user account
	 *
	 * This command use to list all roles of one accountIdentifier.
	 *
	 * Exaple ./flow user:listroles testUser
	 *
	 * @param string $accountIdentifier The account identifier you want to list its roles
	 *
	 * @return void
	 */
	public function listRolesCommand($accountIdentifier) {
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName($accountIdentifier, $this->authenticationProviderName);
		if (!$account) {
			$this->outputLine('FAILED! Account "' . $accountIdentifier . '" does not exist!');
			return;
		}
		$this->outputLine('Roles for account "' . $accountIdentifier . '":');
		foreach ($account->getRoles() as $role) {
			$this->outputLine('- ' . $role);
		}
	}

	/**
	 * Adds specified role to the given user account
	 *
	 * Command use to add role to specify account that you want.
	 *
	 * Example ./flow user:addrole testuser Administrator
	 *
	 * @param string $accountIdentifier The account identifier you want to add role to
	 * @param string $roleIdentifier    The role identifier to be added to the account (User or Administrator)
	 *
	 * @return void
	 */
	public function addRoleCommand($accountIdentifier, $roleIdentifier) {
		$account = $this->accountRepository->findByAccountIdentifierAndAuthenticationProviderName(
			$accountIdentifier, $this->authenticationProviderName);
		if (! $account) {
			$this->outputLine('FAILED! Account "' . $accountIdentifier . '" does not exist!');
			return;
		}

		if (! in_array($roleIdentifier, Utility::getAllowedRoleIdentifiers())) {
			$this->outputLine('FAILED! Role identifier "' . $roleIdentifier . '" is not allowed!');
			$this->outputLine('Allowed role identifiers: ' . implode(' or ', Utility::getAllowedRoleIdentifiers()));
			return;
		}

		if (in_array($roleIdentifier, $account->getRoles())) {
			$this->outputLine('SKIPPED! Account "' . $accountIdentifier . '" already has "' . $roleIdentifier . '" role!');
			return;
		}

		$account->addRole(new \TYPO3\Flow\Security\Policy\Role($roleIdentifier));
		$this->accountRepository->update($account);
		$this->persistenceManager->persistAll();
		$this->outputLine('Current roles:');
		foreach ($account->getRoles() as $role) {
			$this->outputLine('- ' . $role);
		}
	}

}

?>
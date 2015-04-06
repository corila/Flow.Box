<?php
namespace Flow\Box\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\QueryResultInterface;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class UserRepository extends Repository {

	/**
	 * Find users by their role
	 * @param string $roleIdentifier
	 * @param boolean $reverse
	 *
	 * @return QueryResultInterface
	 */
	public function findByRole($roleIdentifier, $reverse = FALSE) {
		$query = $this->createQuery();
		$constraints = $query->equals('accounts.roles.identifier', $roleIdentifier);
		if ($reverse) {
			$constraints = $query->logicalNot($constraints);
		}

		return $query->matching($constraints)->execute();
	}

}
?>
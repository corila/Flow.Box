<?php
namespace Flow\Box\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class SeedRepository extends Repository {

	/**
	 * get all seeds aascending
	 *
	 * @return array Seed
	 */
	public function findAll() {
		$query = $this->createQuery();
		return $query->setOrderings(array('orderItem' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
	}

	/**
	 * get all main seeds aascending
	 *
	 * @return array Seed
	 */
	public function findMainSeeds() {
		$query = $this->createQuery();
		$constrain = $query->equals('parentSeed', NULL);
		return $query->matching($constrain)->setOrderings(array('orderItem' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
	}

	/**
	 * get the greatest order
	 *
	 * @return Seed
	 */
	public function findGreatestOrder($parent = NULL) {
		$query = $this->createQuery();
		$query->matching($query->equals('parentSeed', $parent));
		return $query->setOrderings(array('orderItem' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_DESCENDING))->execute()->getFirst();
	}

}
?>
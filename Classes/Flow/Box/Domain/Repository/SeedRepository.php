<?php
namespace Flow\Box\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;
use Flow\Box\Domain\Model\Seed;

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

	/**
	 * get seed(parent) to update order
	 * @param int $order
	 * @return Seed
	 */
	public function findOrderOfParent($order) {
		$query = $this->createQuery();
		$constrain = $query->logicalAnd($query->equals('parentSeed', NULL),
										$query->equals('orderItem', $order));
		return $query->matching($constrain)->execute()->getFirst();
	}

	/**
	 * get seed(child) to update order
	 * @param string $parent
	 * @param int $order
	 * @return Seed
	 */
	public function findOrderOfChild($parent = null, $order) {
		$query = $this->createQuery();
		$constrain = $query->logicalAnd($query->equals('parentSeed', $parent),
										$query->equals('orderItem', $order));
		return $query->matching($constrain)->execute()->getFirst();
	}
	
	/**
	 * get the greatest order
	 * @param Seed $parent
	 * @return Seed
	 */
	public function findOrderByParent(Seed $parent) {
		$query = $this->createQuery();
		$constrain = $query->equals('parentSeed', $parent);
		return $query->matching($constrain)->setOrderings(array('orderItem' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
	}
}
?>
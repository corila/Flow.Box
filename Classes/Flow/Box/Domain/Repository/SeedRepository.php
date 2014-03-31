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
	 * @return array Service
	 */
	public function findAll() {
		$query = $this->createQuery();
		return $query->setOrderings(array('orderItem' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
	}

}
?>
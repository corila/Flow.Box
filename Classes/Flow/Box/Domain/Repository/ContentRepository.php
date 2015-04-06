<?php
namespace Flow\Box\Domain\Repository;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use Flow\Box\Domain\Model\FeMenu;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class ContentRepository extends Repository {

	/**
	 * @param FeMenu $feMenu
	 * @return \Flow\Box\Domain\Model\Content|NULL
	 */
	public function findByFeMenu(FeMenu $feMenu) {
		$query = $this->createQuery();
		$constrain = $query->equals('feMenu', $feMenu);
		$query = $query->matching($constrain);
		return $query->execute()->getFirst();
	}

}
?>
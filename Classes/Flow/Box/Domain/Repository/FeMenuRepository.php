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
class FeMenuRepository extends Repository {

	/**
	 * @var array
	 */
	protected $defaultOrderings = array(
		'menuOrder' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING
	);


}
?>
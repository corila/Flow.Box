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
class LabelRepository extends Repository {

	/**
	 * @var array
	 */
	protected $defaultOrderings = array(
		'sorting' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING,
		'labelName' => \TYPO3\Flow\Persistence\QueryInterface::ORDER_ASCENDING
	);

	/**
	 * @param integer $limit
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findWithLimit($limit = 9) {
		return $this->createQuery()->setLimit($limit)->execute();
	}


	/**
	 * @param string $title
	 * @return \TYPO3\Flow\Persistence\QueryResultInterface
	 */
	public function findByOptions($title) {
		$query = $this->createQuery();
		$constraint = $query->logicalOr(
			$query->like('labelName', '%' . $title . '%'),
			$query->like('sysKey', '%' . $title . '%'),
			$query->like('sysValue', '%' . $title . '%')
		);
		return $query->matching($constraint)->execute();
	}

}
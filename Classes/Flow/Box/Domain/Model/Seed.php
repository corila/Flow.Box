<?php
namespace Flow\Box\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Seed {

	/**
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var int
	 */
	protected $orderItem;

	/**
	 * Get identifier
	 *
	 * @return string
	 */
	public function getIdentifier() {
		return $this->persistenceManager->getIdentifierByObject($this);
	}

	/**
	 * @return string
	 */
	public function getName() {
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name) {
		$this->name = $name;
	}

	/**
	 * @return int
	 */
	public function getOrderItem() {
		return $this->orderItem;
	}
	
	/**
	 * @param int $orderItem
	 * @return void
	 */
	public function setOrderItem($orderItem) {
		$this->orderItem = $orderItem;
	}
}
?>
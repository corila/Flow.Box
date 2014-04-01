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
	 * The parentSeed
	 * @var \Flow\Box\Domain\Model\Seed
	 * @ORM\ManyToOne
	 * @ORM\JoinColumn(referencedColumnName="persistence_object_identifier")
	 */
	protected $parentSeed;
	
	/**
	 * The children seeds
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Flow\Box\Domain\Model\Seed>
	 * @ORM\OneToMany(targetEntity="Flow\Box\Domain\Model\Seed", mappedBy="parentSeed", cascade={"remove"})
	 */
	protected $childrenSeed;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var int
	 * @ORM\Column(type="integer")
	 */
	protected $orderItem;

	/**
	 * @var int
	 * @ORM\Column(type="integer", nullable=true)
	 */
	protected $quantity;

	/**
	 * @return \Flow\Box\Domain\Model\Seed
	 */
	public function getParentSeed() {
		return $this->parentSeed;
	}
	
	/**
	 * @param \Flow\Box\Domain\Model\Seed $parentSeed
	 * @return void
	 */
	public function setParentSeed($parentSeed) {
		$this->parentSeed = $parentSeed;
	}

	/**
	 * Get all children of this seed
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Flow\Box\Domain\Model\Seed> The children of this seed
	 */
	public function getChildrenSeeds() {
		return $this->childrenSeeds;
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

	/**
	 * @return int
	 */
	public function getQuantity() {
		return $this->quantity;
	}
	
	/**
	 * @param int $quantity
	 * @return void
	 */
	public function setQuantity($quantity) {
		$this->quantity = $quantity;
	}
}
?>
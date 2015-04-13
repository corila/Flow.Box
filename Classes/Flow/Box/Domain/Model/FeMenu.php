<?php
namespace Flow\Box\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use Sandstorm\GedmoTranslatableConnector\TranslatableTrait;
use Gedmo\Mapping\Annotation as Gedmo;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class FeMenu {

	use TranslatableTrait;

	/**
	 * @var \TYPO3\Flow\Persistence\PersistenceManagerInterface
	 * @Flow\Inject
	 */
	protected $persistenceManager;

	/**
	 * @var string
	 * @Gedmo\Translatable
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $sysValue;

	/**
	 * @var int
	 * @ORM\Column(unique=true)
	 */
	protected $menuOrder;

	/**
	 * @var FeMenu
	 * @ORM\Column(nullable=true)
	 * @ORM\ManyToOne
	 */
	protected $parentMenu;

	/**
	 * @var FeMenu
	 * @ORM\Column(nullable=true)
	 * @ORM\ManyToOne
	 */
	protected $childrenMenu;

	/**
	 * @return string
	 */
	public function getIdentity() {
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
	 * @return string
	 */
	public function getSysValue() {
		return $this->sysValue;
	}

	/**
	 * @param string $sysValue
	 * @return void
	 */
	public function setSysValue($sysValue) {
		$this->sysValue = $sysValue;
	}

	/**
	 * @return int
	 */
	public function getMenuOrder() {
		return $this->menuOrder;
	}

	/**
	 * @param int $menuOrder
	 * @return void
	 */
	public function setMenuOrder($menuOrder) {
		$this->menuOrder = $menuOrder;
	}

	/**
	 * @return FeMenu
	 */
	public function getParentMenu() {
		return $this->parentMenu;
	}


	/**
	 * @param FeMenu $childrenMenu
	 */
	public function setChildrenMenu($childrenMenu) {
		$this->childrenMenu = $childrenMenu;
	}

}
?>
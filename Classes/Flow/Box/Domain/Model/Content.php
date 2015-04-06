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
use Flow\Box\Domain\Model\FeMenu;

/**
 * @Flow\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Content {

	use TranslatableTrait;

	/**
	 * @var string
	 * @ORM\Column(type="text", nullable=true)
	 */
	protected $description;

	/**
	 * @var FeMenu
	 * @ORM\ManyToOne
	 */
	protected $feMenu;

	/**
	 * @return string
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * @return FeMenu
	 */
	public function getFeMenu() {
		return $this->feMenu;
	}

	/**
	 * @param FeMenu $feMenu
	 */
	public function setFeMenu(FeMenu $feMenu) {
		$this->feMenu = $feMenu;
	}

}
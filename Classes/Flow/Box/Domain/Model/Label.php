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
 * @ORM\HasLifecycleCallbacks
 */
class Label {

	use TranslatableTrait;

	/**
	 * @var string
	 */
	protected $labelName;

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $sysKey;

	/**
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\Column(type="text")
	 * @Gedmo\Translatable
	 */
	protected $sysValue;

	/**
	 * @return string
	 */
	public function getLabelName() {
		return $this->labelName;
	}

	/**
	 * @param string $labelName
	 */
	public function setLabelName($labelName) {
		$this->labelName = $labelName;
	}

	/**
	 * @return string
	 */
	public function getSysKey() {
		return $this->sysKey;
	}

	/**
	 * @param string $sysKey
	 */
	public function setSysKey($sysKey) {
		$this->sysKey = $sysKey;
	}

	/**
	 * @return string
	 */
	public function getSysValue() {
		return $this->sysValue;
	}

	/**
	 * @param string $sysValue
	 */
	public function setSysValue($sysValue) {
		$this->sysValue = $sysValue;
	}

}
?>

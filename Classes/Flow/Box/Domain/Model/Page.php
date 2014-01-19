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
class Page {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $subTitle;

	/**
	 * @var \DateTime
	 */
	protected $publishDate;

	/**
	 * @var \DateTime
	 */
	protected $expireDate;


	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getSubTitle() {
		return $this->subTitle;
	}

	/**
	 * @param string $subTitle
	 * @return void
	 */
	public function setSubTitle($subTitle) {
		$this->subTitle = $subTitle;
	}

	/**
	 * @return \DateTime
	 */
	public function getPublishDate() {
		return $this->publishDate;
	}

	/**
	 * @param \DateTime $publishDate
	 * @return void
	 */
	public function setPublishDate($publishDate) {
		$this->publishDate = $publishDate;
	}

	/**
	 * @return \DateTime
	 */
	public function getExpireDate() {
		return $this->expireDate;
	}

	/**
	 * @param \DateTime $expireDate
	 * @return void
	 */
	public function setExpireDate($expireDate) {
		$this->expireDate = $expireDate;
	}

}
?>
<?php
namespace Flow\Box\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use Flow\Box\Domain\Model\Project;
use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Task {

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var int
	 */
	protected $point;

	/**
	 * @var string
	 * @Flow\Validate(type="Text")
	 * @ORM\Column(nullable = true)
	 */
	protected $description = NULL;

	/**
	 * @var \DateTime
	 * @ORM\Column(nullable = true)
	 */
	protected $createDate;

	/**
	 * @var \DateTime
	 * @ORM\Column(nullable = true)
	 */
	protected $modifiedDate;

	/**
	 * @var Project
	 * @Flow\Validate(type="NotEmpty")
	 * @ORM\ManyToOne
	 */
	protected $project;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->createDate = new \DateTime();
		$this->modifiedDate = new \DateTime();
	}

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
	 * @return int
	 */
	public function getPoint()
	{
		return $this->point;
	}

	/**
	 * @param int $point
	 */
	public function setPoint($point)
	{
		$this->point = $point;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription($description)
	{
		$this->description = $description;
	}

	/**
	 * @return mixed
	 */
	public function getCreateDate()
	{
		return $this->createDate;
	}

	/**
	 * @param mixed $createDate
	 */
	public function setCreateDate($createDate)
	{
		$this->createDate = $createDate;
	}

	/**
	 * @return \DateTime
	 */
	public function getModifiedDate()
	{
		return $this->modifiedDate;
	}

	/**
	 * @param \DateTime $modifiedDate
	 */
	public function setModifiedDate($modifiedDate)
	{
		$this->modifiedDate = $modifiedDate;
	}

	/**
	 * @return Project
	 */
	public function getProject()
	{
		return $this->project;
	}

	/**
	 * @param Project $project
	 */
	public function setProject(Project $project)
	{
		$this->project = $project;
	}
}
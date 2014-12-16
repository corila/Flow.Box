<?php
namespace Flow\Box\Backend\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use Flow\Box\Domain\Model\Project;
use TYPO3\Flow\Annotations as Flow;
use Flow\Box\Domain\Model\Page;

class ProjectController extends MainBackendController {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\ProjectRepository
	 */
	protected $projectRepository;

	/**
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('projects', $this->projectRepository->findAll());
	}

	/**
	 * @param Project $project
	 */
	public function newAction(Project $project = NULL) {
		$this->view->assign('project', $project);
	}

	/**
	 * @param Project $project
	 */
	public function createAction(Project $project) {
		$this->projectRepository->add($project);
		$this->redirect('index');
	}
}

?>
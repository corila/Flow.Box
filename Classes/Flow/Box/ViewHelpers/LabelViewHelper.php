<?php
namespace Flow\Box\ViewHelpers;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.Fluid".           *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\Fluid\Core\ViewHelper;
use TYPO3\Flow\Annotations as Flow;

/**
 * This ViewHelper counts elements of the specified array or countable object.
 *
 * = Examples =
 *
 * <code title="Count array elements">
 * <box:label sysKey="someKey" />
 * </code>
 * <output>
 * Some value
 * </output>
 *
 * @api
 */
class LabelViewHelper extends AbstractViewHelper {

	/**
	 * @Flow\Inject
	 * @var \Flow\Box\Domain\Repository\LabelRepository
	 */
	protected $labelRepository;

	/**
	 * @param $sysKey
	 * @return string
	 */
	public function render($sysKey) {
		$sysValue = '';
		$label = $this->labelRepository->findOneBySysKey($sysKey);
		if ($label) {
			$sysValue = $label->getSysValue();
		}
		return $sysValue;
	}
}

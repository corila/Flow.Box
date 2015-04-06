<?php
namespace Flow\Box\Aspect;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Flow.Box".              *
 *                                                                        *
 *                                                                        */

use Gedmo\Translatable\TranslatableListener;
use TYPO3\Flow\Annotations as Flow;

/**
 * Class LanguageDetectionAspect
 *
 * @Flow\Aspect
 * @Flow\Scope("singleton")
 */
class LanguageDetectionAspect {

	/**
	 * @Flow\Inject
	 * @var TranslatableListener
	 */
	protected $translatableListener;

	/**
	 * @var \TYPO3\Flow\I18n\Service
	 * @Flow\Inject
	 */
	protected $localisationService;

	/**
	 * @var \TYPO3\Flow\Configuration\ConfigurationManager
	 * @Flow\Inject
	 */
	protected $configurationManager;

	/**
	 * @var array
	 */
	protected $availableLanguages = array();

	/**
	 * @var string
	 */
	protected $defaultLocalization = '';

	/**
	 * @var string
	 */
	protected $incomingUrlValue = '';

	/**
	 * Initializes the object after all dependencies have been injected
	 */
	public function initializeObject() {
		$languageConfiguration = $this->configurationManager->getConfiguration('Settings', 'languages');
		$this->availableLanguages = $languageConfiguration['routing'];
		$localeRootPathMap = array_flip($languageConfiguration['routing']);
		$this->defaultLocalization = $localeRootPathMap[$languageConfiguration['default']];
	}

	/**
	 * @Flow\Before("method(TYPO3\Flow\Mvc\ActionRequest->setArgument(argumentName == 'language'))")
	 * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
	 * @return void
	 *
	 * @throws  \TYPO3\Flow\Mvc\Exception\NoMatchingRouteException
	 */
	public function setLanguage(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
		$requestedLanguage = strtolower($joinPoint->getMethodArgument('value'));
		if (!array_key_exists($requestedLanguage, $this->availableLanguages)) {
			throw new \TYPO3\Flow\Mvc\Exception\NoMatchingRouteException();
		} else {
			$this->incomingUrlValue = $requestedLanguage;
		}
		$this->localisationService->getConfiguration()->setCurrentLocale(new \TYPO3\Flow\I18n\Locale($this->availableLanguages[$this->incomingUrlValue]));
		if ('en' == $this->incomingUrlValue) {
			$this->translatableListener->setTranslatableLocale($this->incomingUrlValue);
			$this->translatableListener->setTranslationFallback(TRUE);
		}
	}

	/**
	 * @Flow\Around("method(TYPO3\Flow\Mvc\Routing\UriBuilder->mergeArgumentsWithRequestArguments())")
	 * @param \TYPO3\Flow\AOP\JoinPointInterface $joinPoint
	 * @return string
	 */
	public function addLanguageToUriIfSet(\TYPO3\Flow\AOP\JoinPointInterface $joinPoint) {
		$result = $joinPoint->getAdviceChain()->proceed($joinPoint);

		if (!array_key_exists('@subpackage', $result)) {
			if (!array_key_exists('language', $result)) {
				$result['language'] = $this->incomingUrlValue;
			} elseif (!array_key_exists($result['language'], $this->availableLanguages)) {
				$result['language'] = $this->defaultLocalization;
			}
		}
		return $result;
	}
} 
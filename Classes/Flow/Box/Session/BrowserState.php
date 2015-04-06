<?php
namespace Flow\Box\Session;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "WE.KIME".               *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("session")
 */
class BrowserState {

	/**
	 * @var array
	 */
	protected $data = array();

	/**
	 * Set a $value for $key
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 * @Flow\Session(autoStart = TRUE)
	 */
	public function set($key, $value) {
		$this->data[$key] = serialize($value);
	}

	/**
	 * Return a value for $key.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get($key) {
		return isset($this->data[$key]) ? unserialize($this->data[$key]) : NULL;
	}

	/**
	 * Return a value for $key.
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function fetch($key) {
		if (isset($this->data[$key])) {
			$value = unserialize($this->data[$key]);
			$this->remove($key);
			return $value;
		} else {
			return NULL;
		}
	}

	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public function hasKey($key) {
		return isset($this->data[$key]);
	}

	/**
	 * @param $key
	 *
	 * @return void
	 */
	public function remove($key) {
		if (array_key_exists($key, $this->data)) {
			unset($this->data[$key]);
		}
	}
}
?>
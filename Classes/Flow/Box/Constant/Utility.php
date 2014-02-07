<?php
namespace Flow\Box\Constant;

/*                                                                    *
 * This script belongs to the package "Internezzo.VersionControl".    *
 *                                                                    */

use TYPO3\Flow\Annotations as Flow;

/**
 * Helper utility for the Flow.Box package
 *
 * @Flow\Scope("singleton")
 */
class Utility {

	const USER_IDENTIFIER = 'User';
	const ADMINISTRATOR_IDENTIFIER = 'Administrator';


	/**
	 * Get identifier for User role
	 *
	 * @return string
	 */
	public static function getUserIdentifier() {
		return self::USER_IDENTIFIER;
	}

	/**
	 * Get identifier for Administrator role
	 *
	 * @return string
	 */
	public static function getAdministratorIdentifier() {
		return self::ADMINISTRATOR_IDENTIFIER;
	}

	/**
	 * Return array of allowed roles for user
	 *
	 * @return array
	 */
	public static function getAllowedRoleIdentifiers() {
		return array (
			self::USER_IDENTIFIER,
			self::ADMINISTRATOR_IDENTIFIER
		);
	}
}

?>
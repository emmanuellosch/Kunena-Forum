<?php
/**
 * @version $Id: kunena.session.class.php 2071 2010-03-17 11:27:58Z mahagr $
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 *
 **/
//
// Dont allow direct linking
defined( '_JEXEC' ) or die('');

kimport('integration.integration');

abstract class KunenaPrivate
{
	public $priority = 0;

	protected static $instance = false;

	abstract public function __construct();

	static public function getInstance($integration = null) {
		if (self::$instance === false) {
			$config = KunenaFactory::getConfig ();
			if (! $integration)
				$integration = $config->integration_private;
			self::$instance = KunenaIntegration::initialize ( 'private', $integration );
		}
		return self::$instance;
	}

	protected function getOnClick($userid) {}

	abstract protected function getURL($userid);

	public function showIcon($userid)
	{
		$my = JFactory::getUser();

		// Don't send messages from/to anonymous and to yourself
		if ($my->id == 0 || $userid == 0 || $userid == $my->id) return '';

		$url = $this->getURL($userid);

		$onclick = $this->getOnClick($userid);
		// No PMS enabled or PM not allowed
		if (empty($url)) return '';

		// We should offer the user a PM link
		return '<a href="' . $url . '"' .$onclick. ' title="'.JText::_('COM_KUNENA_VIEW_PMS').'"><span class="private" alt="' .JText::_('COM_KUNENA_VIEW_PMS'). '" /></a>';
	}
}

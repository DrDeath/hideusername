<?php
/**
*
* Hide Username extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 Rich McGirr (RMcGirr83)
* @copyright (c) 2021 Stefan Temath (Dr.Death)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\hideusername\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\user */
	protected $user;

	/* @var \phpbb\language\language */
	protected $language;

	/**
	* Constructor
	*
	* @param \phpbb\user							$user
	* @param \phpbb\language\language				$language
	*/
	public function __construct
	(
		\phpbb\user $user,
		\phpbb\language\language $language
	)
	{
		$this->user 	= $user;
		$this->language = $language;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.modify_username_string'	=> 'hide_username',
		);
	}



	/**
	* Don't display username to guests
	*
	* @param object $event The event object
	* @return null
	* @access public
	*/

	public function hide_username($event)
	{
		if ($this->user->data['user_id'] == ANONYMOUS)
		{
			// load extension language
			$this->language->add_lang('common', 'rmcgirr83/hideusername');

			$event['username_string'] = $this->language->lang('HIDE_USERNAME_MEMBER');
		}
	}
}

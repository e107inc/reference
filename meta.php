<?php
/**
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

$_E107['no_online'] = true;
$_E107['no_forceuserupdate'] = true;
$_E107['no_menus'] = true;
require_once("../../class2.php");

if(!ADMIN)
{
	exit;
}




class reference_meta
{


	function __construct()
	{
		$_GET['url'] = urldecode($_GET['url']);

		$url = e107::getParser()->filter($_GET['url'],'url');

		$url = str_replace("url:","http://",$url);

		$data = e107::getFile()->getRemoteContent($url);

		if(empty($data))
		{
			echo "(unable to retrieve data)";
			exit;
		}

		$meta = e107::getParser()->getTags($data,'title,meta');

		$title = $this->getTitle($meta);

		echo $title;

	}

	function getTitle($array)
	{
		if(!empty($array['meta']))
		{
			foreach($array['meta'] as $m)
			{
				if(!empty($m['name']) && $m['name'] == 'og:title')
				{
					return $m['content'];
				}

				if(!empty($m['property']) && $m['property'] == 'og:title')
				{
					return $m['content'];
				}


			}

		//	print_a($array['meta']);

		}

		if(!empty($array['title'][0]['@value']))
		{
			return strip_tags($array['title'][0]['@value']);
		}




	}




}

new reference_meta;


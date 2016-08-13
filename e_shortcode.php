<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
* Featurebox shortcode batch class - shortcodes available site-wide. ie. equivalent to multiple .sc files.
*/

if (!defined('e107_INIT')) { exit; }

class reference_shortcodes extends e_shortcode
{

	
	function __construct()
	{
		require_once(e_PLUGIN."reference/reference_class.php");
   //
	}

	function sc_reference_news()
	{
		$newsReferences = reference::getNews();

		if(!empty($newsReferences))
		{
			$text = "<div class='reference'><h3>Sources</h3>";

			foreach($newsReferences as $k=>$v)
			{
				$text .= "<p><small>".$k.". <a rel='external' id='reference-{$k}' href='".$v['url']."'>".$v['name']."</a>
						</small></p>";
			}

			$text .= "</div>";

			return $text;

		}


	}

}
?>
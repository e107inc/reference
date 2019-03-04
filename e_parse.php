<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2010 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_plugins/linkwords/e_tohtml.php,v $
 * $Revision$
 * $Date$
 * $Author$
 */



if (!defined('e107_INIT')) { exit; }


class reference_parse
{


	/* constructor */
	function __construct()
	{


	}


	function toHTML($text, $context='')
	{
		$text = preg_replace('/\<sup\>(\d*)\<\/sup\>/',"<sup><a href='#reference-$1' title='Go to reference'>$1</a></sup>",$text);
		return $text;
	}



}




?>
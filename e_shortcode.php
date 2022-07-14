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


	function sc_reference_news($parm=null)
	{
		return $this->render('news', $parm);
	}


	function sc_reference_page($parm=null)
	{
		return $this->render('page', $parm);
	}

	/**
	 * Render the reference list.
	 * @param string $type news|page
	 * @param array $parm = [
	 *  'class'     => 'custom class',
	 *  'expandit'  => 1 | 0
	 *  'glyph'     => 'fa-icon'
	 *
	 * ]
	 * @return string
	 */
	private function render($type, $parm=null)
	{

		switch($type)
		{
			case "page":
				$references = reference::getPage();
				break;

			case "news":
				$references = reference::getNews();
				break;
		}

		if(empty($references))
		{
			return null; 
		}


		$class = '';
		$classContainer = '';
		$glyph = '';
		$toggle = '';

		$tmp = e107::pref('reference', 'heading_'.$type, array());
		$title = !empty($tmp[e_LANGUAGE]) ? $tmp[e_LANGUAGE] : "References";
			
		if(!empty($parm['class']))
		{
			$class = ' '.$parm['class'];
		}
			//<div class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseThree">Further References for MSC, BMC, Stemcell Secretome and EVs</div>

		if(!empty($parm['expandit']))
		{
			$class .= ' hide e-expandit';
			$toggle = " data-target='reference-".$type."-container' ";
			$classContainer = ' class="collapse" ';
		}

		if(!empty($parm['glyph']))
		{
			$glyph = e107::getParser()->toGlyph($parm['glyph'],['embed'=>1]);
		}

		$linkIcon = e107::getParser()->toGlyph('fas-external-link-alt',['embed'=>1]);


		$text = "<div class='reference'>".$glyph."<h4 class='".$class."' ".$toggle.">".$title."</h4>
			<div id='reference-".$type."-container' ".$classContainer.">";

		foreach($references as $k=>$v)
		{
			$text .= "<p>".$k.'. ';
		//
			$text .= $v['name'];
		//	$text .= "</small>";
			$text .= " <a rel='nofollow noopener noreferrer external' target='_blank' id='reference-".$k."' href='".$v['url']."'>";
			$text .=  $linkIcon;
			$text .= "</a>";

			if(!empty($parm['description']) && !empty($v['description']))
			{
				$text .= "<small style='display:block;margin-left:15px'>".$v['description']."</small>";
			}

			$text .= "</p>";
		}

		$text .= "</div></div>";

		return $text;

	}
}

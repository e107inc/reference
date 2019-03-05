<?php


	/**
	 * e107 website system
	 *
	 * Copyright (C) 2008-2016 e107 Inc (e107.org)
	 * Released under the terms and conditions of the
	 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
	 *
	 */
	class reference
	{

		static function getNews()
		{

			$sc = e107::getScBatch('news');
			$item = $sc->getScVar('news_item');

			if(!empty($item['news_id']))
			{
				$data = e107::getDb()->retrieve('reference', 'ref_data', "ref_table='news' AND ref_pid=".$item['news_id']);

				if(!empty($data))
				{
					$refs =  e107::unserialize($data);

					$arr = array();

					foreach($refs['url'] as $k=>$v)
					{
						if(empty($v))
						{
							continue;
						}

						$arr[$k] = array('url'=>$v, 'name'=>$refs['name'][$k]);

					}

					return $arr;

				}

			}

			return false;
		}


		static function getPage()
		{

			$sc = e107::getScBatch('page');
			$row= $sc->getVars();

			if(!empty($row['page_id']))
			{
				$data = e107::getDb()->retrieve('reference', 'ref_data', "ref_table='page' AND ref_pid=".(int) $row['page_id']);

				if(!empty($data))
				{
					$refs = e107::unserialize($data);

					$arr = array();

					foreach($refs['url'] as $k=>$v)
					{
						if(empty($v))
						{
							continue;
						}

						$arr[$k] = array('url'=>$v, 'name'=>$refs['name'][$k]);

					}

					return $arr;

				}

			}

			return false;
		}


	}
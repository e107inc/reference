<?php


//v2.x Standard for extending admin areas.


class reference_admin implements e_admin_addon_interface
{
	private $active = false;


	function __construct()
	{
		// $pref = e107::pref('core','trackbackEnabled');
		$this->active = 1;

		e107::js('footer', e_PLUGIN_ABS.'reference/reference.js');

	}

	function load($event, $ids)
	{
		$sql = e107::getDb();
		$data = $sql->retrieve("reference","ref_pid, ref_data", "ref_table='".$event."' AND ref_pid IN(".$ids.")", true);

		$arr = array();
		foreach($data as $row)
		{
			$id = $row['ref_pid'];
			$arr[$id]['url'] = $row['ref_data'];
		}

		return $arr;
	}


	/**
	 * Extend Admin-ui Parameters
	 * @param $ui admin-ui object
	 * @return array
	 */
	public function config(e_admin_ui $ui)
	{
		$action     = $ui->getAction(); // current mode: create, edit, list
		$type       = $ui->getEventName(); // 'wmessage', 'news' etc.
		$id         = $ui->getId();
		$sql        = e107::getDb();

		$config = array();


		switch($type)
		{
			case "news":
			case "page":

				$config['tabs'] = array('ref'=>'References');


				if(($action == 'edit') && !empty($id) && ( $url = $sql->retrieve("reference","ref_data", "ref_table='".$type."' AND ref_pid=".$id)))
				{
					$default = $url;
				}
				else
				{
					$default = '';
				}


				if($this->active == true)
				{
					$config['fields']['url'] =   array ( 'title' =>"Reference", 'type' => 'method',  'tab'=>'ref',  'writeParms'=> array('nolabel'=>true, 'size'=>'xxlarge', 'placeholder'=>'', 'default'=>$default), 'width' => 'auto', 'help' => '', 'readParms' => '', 'class' => 'left', 'thclass' => 'left',  );
				}
				break;
		}

		//Note: 'url' will be returned as $_POST['x_reference_url']. ie. x_{PLUGIN_FOLDER}_{YOURKEY}

		return $config;

	}


	/**
	 * Process Posted Data.
	 * @param $ui admin-ui object
	 */
	public function process(e_admin_ui $ui, $id=0)
	{

		$data       = $ui->getPosted();
		$type       = $ui->getEventName();
		$action     = $ui->getAction(); // current mode: create, edit, list

		$sql = e107::getDb();

	//	e107::getMessage()->addDebug("Object: ".print_a($ui,true));
	//	e107::getMessage()->addInfo("ID: ".$id);
	//	e107::getMessage()->addInfo("Action: ".$action);
	//	e107::getMessage()->addInfo(print_a($data,true));

		if($action == 'delete')
		{
			return;
		}

		if(e_LANGUAGE != 'English')
		{
			return;
		}



		if(!empty($id) && $this->active)
		{

			if(!empty($data['x_reference_url']))
			{

				$refData = e107::serialize($data['x_reference_url'], 'json');

				$insert = array(
						"ref_pid"=> $id,
						"ref_table"=>$type,
						'ref_title'=> !empty($data['news_title']) ? $data['news_title'] : 'unknown',
						'ref_data'=> $refData,
						'_DUPLICATE_KEY_UPDATE' => true
				);

				$result = $sql->insert("reference", $insert);

				if($result !==false)
				{
					e107::getMessage()->addSuccess("References Saved");
				}
				else
				{
					e107::getMessage()->addError("Couldn't save references: ".var_export($result,true));
					e107::getMessage()->addDebug($sql->getLastErrorText());
					e107::getMessage()->addDebug($sql->getLastQuery());
				}


			}


		}



	}



}

class reference_admin_form extends e_form
{

	/**
	 * @param $curval
	 * @param $mode
	 * @param $att
	 * @return null|string
	 */
	function x_reference_url($curval, $mode, $att=null)
	{

		$vals = array();

		if(!empty($curval))
		{
			$vals = json_decode($curval,true);
		}

		switch($mode)
		{
			case "read":

				if(!empty($vals))
				{
					$text = "<ol style='font-size:80%;padding-left:10px'>";

					foreach($vals['url'] as $k => $v)
					{
						if(empty($vals['name'][$k]))
						{
							continue;
						}

						$text .= "<li><a target='_blank' href='" . $v . "'>" . $vals['name'][$k] . "</a></li>";
					}

					$text .= "</ol>";

					return $text;
				}

				return null;
				break;

			case "write":
				$text = "<table class='table table-striped table-condensed table-bordered'>
				<tr><th class='text-right'>No.</th><th>URL</th><th>Title</th></tr>";

				for($i = 1; $i <= 20; $i++)
				{
					$text .= "<tr>
		            <td class='text-right'>" . $i . "</td>
		             <td>" . $this->text('x_reference_url[url][' . $i . ']', $vals['url'][$i], 255, array('class' => 'x-reference-url', 'id' => 'x-reference-url-url-' . $i, 'size' => 'block-level')) . "</td>
		            <td>" . $this->text('x_reference_url[name][' . $i . ']', $vals['name'][$i], 255, array('id' => 'x-reference-url-name-' . $i, 'size' => 'block-level')) . "</td>
		            </tr>";
				}

				$text .= "</table>";

				$text .= $this->hidden('meta-parse', SITEURLBASE . e_PLUGIN_ABS . "reference/meta.php", array('id' => 'meta-parse'));

				return $text;
				break;

			default:
				// code to be executed if n is different from all labels;
		}





		return null;


	}

}


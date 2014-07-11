<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the CrudItems Component
 */
class CrudItemsViewItems extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$document = JFactory::getDocument();

		$document->addStyleSheet(JURI::base() . 'components/com_cruditems/assets/css/bootstrap.css');
        $document->addScript(JURI::base() . 'components/com_cruditems/assets/js/bootstrap.js');


		$user = JFactory::getUser();
		$signin = sizeof($user->groups);
		if (!$signin){
		    //do stuff
		}
		if ($this->getLayout() == 'edit') {
			// Assign data to the view
	 		$this->id = JRequest::getInt('id', 0) ;

			$this->category_id = JRequest::getInt('category_id', 0);


	 		// new entry
			$this->header = "Add New Item";

 			$this->title= "";
 			$this->content= "";

 			//update existing entry
	 		if ($this->id){
				$this->header = "Edit Item";

				$item = $this->get('Item');
	 			$this->title= $item->title;
 				$this->content= $item->content;
 				$this->category_id= $item->category_id;

	 		}

		    parent::display($tpl);
		    return;
		}

		
		
		$this->category_id = JRequest::getInt('category_id', 0);
		$this->category_name = $this->get('Name');

		$this->header = $this->category_name . " Items";
 		$this->items = $this->get('Items');


 		$folder_model = JModel::getInstance('folders', 'CrudItemsModel');

 		foreach ($this->items as $index => $item){
 			$item->folders = $folder_model->getFolders($item->id);
 		}



		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);
	}
}

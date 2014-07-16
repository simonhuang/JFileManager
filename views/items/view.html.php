<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the JFileManager Component
 */
class JFileManagerViewItems extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		// add stylesheets and scripts
		$document = JFactory::getDocument();
		$document->addScript(JURI::base() . 'components/com_jfilemanager/assets/js/jquery-1.11.1.min.js');
		$document->addStyleSheet(JURI::base() . 'components/com_jfilemanager/assets/css/bootstrap.css');
        $document->addScript(JURI::base() . 'components/com_jfilemanager/assets/js/bootstrap.js');
        $document->addStyleSheet(JURI::base() . 'components/com_jfilemanager/assets/css/styles.css');


        // check if public or signed-in user
		$user = JFactory::getUser();
		$signin = sizeof($user->groups);
		if (!$signin){
		    //do stuff
		}


		if ($this->getLayout() == 'edit') {
			// assign data to the edit view


			// grab http get variables
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

	 		// display template;
		    parent::display($tpl);
		    return;
		}

		
		// assign data to the default view
		$this->category_id = JRequest::getInt('category_id', 0);

		// get data from model
		$this->category_name = $this->get('Name');
		$this->header = $this->category_name . " Items";
 		$this->items = $this->get('Items');

 		// get other models
 		$folder_model = JModel::getInstance('folders', 'JFileManagerModel');
 		$file_model = JModel::getInstance('files', 'JFileManagerModel');

 		foreach ($this->items as $index => $item){
 			$item->folders = $folder_model->getRootFolders($item->id);

 			foreach ($item->folders as $folder){
	 			// get sub folders via helper function
	 			$this->getFolders($folder, $folder_model, $file_model);
 			}

 			// $item->folders->files = $file_model->getFiles($folder->id);
 		}


 		// variable to keep track of current item for folder partial view
 		$this->item_count = 0;
 		// stack to keep track of current folder for folder partial view
 		$this->traverse = array();

		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Display the view
		parent::display($tpl);
	}

	public function getFolders ($folder, $folder_model, $file_model){
		// get folders 
		$folder->folders = $folder_model->getFolders($folder->id);

		// get files
		$folder->files = $file_model->getFiles($folder->id);

		// recursively grab child folders (recursion is oh so beautiful)
		foreach ($folder->folders as $folder){
			$this->getFolders($folder, $folder_model, $file_model);
		}
	}
}

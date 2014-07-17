<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the JFileManager Component
 */
class JFileManagerViewJFileManager extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$document = JFactory::getDocument();

        $document->addScript(JURI::base() . 'components/com_jfilemanager/assets/js/jquery-1.11.1.min.js');


		$document->addStyleSheet(JURI::base() . 'components/com_jfilemanager/assets/css/bootstrap.css');
        $document->addScript(JURI::base() . 'components/com_jfilemanager/assets/js/bootstrap.js');
        $document->addStyleSheet(JURI::base() . 'components/com_jfilemanager/assets/css/styles.css');


		$user = JFactory::getUser();
		$signin = sizeof($user->groups);
		if (!$signin){
		    //do stuff
		}
		if ($this->getLayout() == 'edit') {
			// Assign data to the view
	 		$this->id = JRequest::getInt('id', 0) ;


	 		// new entry
			$this->header = "Add New Category";

 			$this->name= "";

 			//update existing entry
	 		if ($this->id){
				$this->header = "Edit Category";

				$category = $this->get('Category');
	 			$this->name= $category->name;

	 		}

		    parent::display($tpl);
		    return;
		}

		

		$this->header = "Categories";
 		$this->categories = $this->get('Categories');

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

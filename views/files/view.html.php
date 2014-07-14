<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the CrudItems Component
 */
class CrudItemsViewFiles extends JView
{
	// Overwriting JView display method
	function display($tpl = null) 
	{
		$document = JFactory::getDocument();
		$document->addScript(JURI::base() . 'components/com_cruditems/assets/js/jquery-1.11.1.min.js');
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
			$this->folder_id = JRequest::getInt('folder_id', 0);


	 		// new entry
			$this->header = "Add New File";

 			$this->name= "";

		    parent::display($tpl);
		    return;
		}
	}
}

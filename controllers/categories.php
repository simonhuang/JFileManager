<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class CrudItemsControllerCategories extends JControllerForm
{

	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('categories');

		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

        // Now update the loaded data to the database via a function in the model
        $upditem	= $model->updCategory($data);

    	// check if ok and display appropriate message.  This can also have a redirect if desired.

        if ($upditem) {
        	JError::raiseNotice( 100, 'Category successfuly saved!' );
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Category not saved' );
        }   
        $url = JRoute::_('index.php?option=com_cruditems&view=categories');
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		$id = JRequest::getInt('id', 0);

		$model	= $this->getModel('categories');
		$model->deleteCategory($id);

		JError::raiseNotice( 100, 'Category successfuly deleted.' );

		$app	= JFactory::getApplication();
		$url = JRoute::_('index.php?option=com_cruditems&view=categories');
		$app->redirect($url);
	}
}

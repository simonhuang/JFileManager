<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class JFileManagerControllerCategories extends JControllerForm
{

	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	public function submit()
	{
		// check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// initialise variables
		$app	= JFactory::getApplication();
		$model	= $this->getModel('categories');

		// get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');

        // load data to the database via a function in the model
        $upditem	= $model->updCategory($data);

    	// check if ok and display appropriate message and redirect
        if ($upditem) {
        	JError::raiseNotice( 100, 'Category successfuly saved!' );
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Category not saved' );
        }   
        $url = JRoute::_('index.php?option=com_jfilemanager&view=categories');
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		// grab get variables
		$id = JRequest::getInt('id', 0);

		// get model and delete category by id via function in the model
		$model	= $this->getModel('categories');
		$model->deleteCategory($id);

		// enqueue notice
		JError::raiseNotice( 100, 'Category successfuly deleted.' );

		// redirect to default categories view
		$app	= JFactory::getApplication();
		$url = JRoute::_('index.php?option=com_jfilemanager&view=categories');
		$app->redirect($url);
	}
}

<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class CrudItemsControllerItems extends JControllerForm
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
		$model	= $this->getModel('items');

		// Get the data from the form POST
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$img = JRequest::getVar('jform', array(), 'files', 'array');

		$category_id = $data['category_id'];
        // Now update the loaded data to the database via a function in the model
        $upditem = $model->updItem($data, $img);

    	// check if ok and display appropriate message.  This can also have a redirect if desired.

        if ($upditem) {
        	JError::raiseNotice( 100, 'Category successfuly saved!' );
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Category not saved' );
        }   
        $url = JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category_id);
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		$id = JRequest::getInt('id', 0);

		$model	= $this->getModel('items');
		$model->deleteItem($id);

		JError::raiseNotice( 100, 'Item successfuly deleted.' );

		$category_id = JRequest::getInt('category_id', 0);
		$category_name = $model->getName();

		$app	= JFactory::getApplication();
		$url = JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category_id.'&category_name='.$category_name);
		$app->redirect($url);
	}
}

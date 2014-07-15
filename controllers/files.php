<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class JFileManagerControllerFiles extends JControllerForm
{

	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	
	public function submit()
	{
		// check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// initialize key variables
		$app	= JFactory::getApplication();
		$model	= $this->getModel('files');

		// get post data
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$file = JRequest::getVar('jform', array(), 'files', 'array');

		// add file using post data via a function in the model
        $upditem = $model->addFile($data, $file);

        // check result and display message
        if ($upditem) {
        	JError::raiseNotice( 100, 'Folder successfuly saved!');
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Folder not saved.');
        }   

        // get category from the model and redirect
        $category_id = $model->getCategoryId($data['folder_id']);
        $url = JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category_id);
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		// initialize key variables
		$app	= JFactory::getApplication();
		$model	= $this->getModel('files');

		// grab http get variables
		$id = JRequest::getInt('id', 0);
		$folder_id = JRequest::getInt('folder_id', 0);

		// delete file via function in the model
		$model->deleteFile($id);

		// get category from the model and redirect
		$category_id = $model->getCategoryId($folder_id);
        $url = JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category_id);
		$app->redirect($url);
	}
	public function downloadFile(){
		// initialize model and send file to client via function in the model
		$model	= $this->getModel('files');
		$model->downloadFile();
	}
}

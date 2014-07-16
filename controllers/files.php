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
		$folder_model	= $this->getModel('folders');

		// get post data
		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$file = JRequest::getVar('jform', array(), 'files', 'array');

		$path = $folder_model->generatePath($data['folder_id']);

		// add file using post data via a function in the model
        $success = $model->addFile($data, $file, $path);

        // check result and display message
        if ($success) {
        	JError::raiseNotice( 100, 'Folder successfuly saved!');
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Folder not saved.');
        }   

        // get category from the model and redirect
        $category_id = $folder_model->getCategoryId($path, 0);
        $url = JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category_id);
		$app->redirect($url);

		return true;
	}
	
	public function delete()
	{
		// initialize key variables
		$app	= JFactory::getApplication();
		$model	= $this->getModel('files');
		$folder_model	= $this->getModel('folders');

		// grab http get variables
		$id = JRequest::getInt('id', 0);
		$file_name = JRequest::getString('file_name', 0);
		$folder_id = JRequest::getInt('folder_id', 0);
		$folder_name = JRequest::getString('folder_name', 0);

		$path = $folder_model->generatePath($folder_id);

		// delete file via function in the model
		$model->deleteFile($id, $file_name, $path);

		// get category from the model and redirect
		$category_id = $folder_model->getCategoryId($path, 0);
        $url = JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category_id);
		$app->redirect($url);
	}

	public function downloadFile(){
		// initialize model and send file to client via function in the model
		$model	= $this->getModel('files');
		$folder_model	= $this->getModel('folders');

		// get path to folder
		$folder_id = JRequest::getInt('folder_id', 0);
		$path = $folder_model->generatePath($folder_id);

		// get the file using the path
		$model->downloadFile($path);
	}
}

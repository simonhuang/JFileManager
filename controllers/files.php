<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class CrudItemsControllerFiles extends JControllerForm
{

	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	
	public function submit()
	{
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		$app	= JFactory::getApplication();
		$model	= $this->getModel('files');

		$data = JRequest::getVar('jform', array(), 'post', 'array');
		$file = JRequest::getVar('jform', array(), 'files', 'array');
        $upditem = $model->addFile($data, $file);

        if ($upditem) {
        	JError::raiseNotice( 100, 'Folder successfuly saved!');
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Folder not saved.');
        }   

        $category_id = $model->getCategoryId($data['folder_id']);
        $url = JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category_id);
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		$app	= JFactory::getApplication();
		$model	= $this->getModel('files');

		$id = JRequest::getInt('id', 0);
		$folder_id = JRequest::getInt('folder_id', 0);

		$model	= $this->getModel('files');
		$model->deleteFile();

		$category_id = $model->getCategoryId($folder_id);
		
        $url = JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category_id);
		$app->redirect($url);
	}
	public function downloadFile(){
		$model	= $this->getModel('files');
		$model->downloadFile();
	}
}

<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class JFileManagerControllerFolders extends JControllerForm
{

	public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, array('ignore_request' => false));
	}

	
	public function submit()
	{
		// check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// initilize key variables
		$app	= JFactory::getApplication();
		$model	= $this->getModel('folders');

		// get posted data
		$data = JRequest::getVar('jform', array(), 'post', 'array');


		// check for folder create name conflicts with existing folders
		if ($data['id']){
			//update folder

			if ($model->isDuplicate($data['folder_name'], $data['id'])){

				// if folder already exists, avoid overwriting original folder
				JError::raiseNotice( 100, 'Folder name already exists.' );

		        $url = JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&id='.$data['id']);
				$app->redirect($url);
	        	JFactory::getApplication()->close();

			}

		} else {
			
			// new folder
	        if (file_exists('components/com_jfilemanager/assets/files/'.$data['folder_name'])) {

	        	// if folder already exists, avoid overwriting original folder
	        	JError::raiseNotice( 100, 'Folder name already exists.' );

		        $url = JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&id='.$data['id']);
				$app->redirect($url);
	        	JFactory::getApplication()->close();
			}
		}

		// update or create folder via function in the model
        $upditem = $model->updFolder($data);

        // set appropriate message
        if ($upditem) {
        	JError::raiseNotice( 100, 'Folder successfuly saved!');
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Folder not saved.');
        }   

        // get category id via model function for redirect
		$category_id = $model->getCategoryID($data['item_id']);
        $url = JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category_id);
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		// initilize key variables
		$id = JRequest::getInt('id', 0);
		$model	= $this->getModel('folders');

		// delete folder via function in the model
		$model->deleteFolder();

		// set message
		JError::raiseNotice( 100, 'Folder successfuly deleted.' );


		// get items model in order to get the category id for redirect

		$items_model	= $this->getModel('items');

		$category_id = JRequest::getInt('category_id', 0);
		$category_name = $items_model->getName();

		$app	= JFactory::getApplication();
		$url = JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category_id.'&category_name='.$category_name);
		$app->redirect($url);
	}
}

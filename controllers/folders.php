<?php

// No direct access.
defined('_JEXEC') or die;

// Include dependancy of the main controllerform class
jimport('joomla.application.component.controllerform');

class CrudItemsControllerFolders extends JControllerForm
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
		$model	= $this->getModel('folders');

		$data = JRequest::getVar('jform', array(), 'post', 'array');

		$category_id = $model->getCategoryID($data['item_id']);

        //create and edit file folder
		if ($data['id']){
			//update folder

			if ($model->isDuplicate($data['folder_name'], $data['id'])){
				JError::raiseNotice( 100, 'Folder name already exists.' );

		        $url = JRoute::_('index.php?option=com_cruditems&view=folders&layout=edit&id='.$data['id']);
				$app->redirect($url);
	        	JFactory::getApplication()->close();

			} else {
				if (!file_exists('components/com_cruditems/assets/files/'.$data['folder_name'])) {
				    mkdir('components/com_cruditems/assets/files/'.$data['folder_name'], 0777, true);
				}
			}

		} else {
			
			//new folder
	        if (file_exists('components/com_cruditems/assets/files/'.$data['folder_name'])) {
	        	JError::raiseNotice( 100, 'Folder name already exists.' );

		        $url = JRoute::_('index.php?option=com_cruditems&view=folders&layout=edit&id='.$data['id']);
				$app->redirect($url);
	        	JFactory::getApplication()->close();
			} else {
			    mkdir('components/com_cruditems/assets/files/'.$data['folder_name'], 0777, true);
			}

		}

        $upditem = $model->updFolder($data);

        if ($upditem) {
        	JError::raiseNotice( 100, 'Folder successfuly saved!');
        } else {
            JError::raiseNotice( 100, 'An error has occured. <br> Folder not saved.');
        }   
        $url = JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category_id);
		$app->redirect($url);

		return true;
	}
	public function delete()
	{
		$id = JRequest::getInt('id', 0);

		$model	= $this->getModel('folders');
		$model->deleteFolder();

		JError::raiseNotice( 100, 'Folder successfuly deleted.' );

		$items_model	= $this->getModel('items');

		$category_id = JRequest::getInt('category_id', 0);
		$category_name = $items_model->getName();

		$app	= JFactory::getApplication();
		$url = JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category_id.'&category_name='.$category_name);
		$app->redirect($url);
	}
}

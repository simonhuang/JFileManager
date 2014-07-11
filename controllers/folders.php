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

        $upditem = $model->updFolder($data);

        //create file folder
        if (file_exists('components/com_cruditems/assets/files/'.$data['name'])) {
        	JError::raiseNotice( 100, 'Folder name already exists.' );
		} else {
		    mkdir('components/com_cruditems/assets/files/'.$data['name'], 0777, true);
		}
		
        $see = JPATH_COMPONENT;
        $see2 = JRoute::_('index.php?option=com_cruditems&view=items');
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

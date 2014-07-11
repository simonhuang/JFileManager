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

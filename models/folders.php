<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');
/**
 * CrudItems Model
 */
class CrudItemsModelFolders extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */

	public function getFolders($item_id) 
	{
		$db = JFactory::getDBO();

		$sql = "SELECT id, name
				FROM #__crudfolders
				WHERE item_id = $item_id";

		$db->setQuery($sql);

		$folders = $db->loadObjectList();

		return $folders;
	}

	public function getFolder()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0) ;

		$sql = "SELECT id, item_id, name
				FROM #__crudfolders
				WHERE id = $id";

		$db->setQuery($sql);

		$folder = $db->loadObject();

		return $folder;
	}

	public function deleteFolder()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0) ;

		$sql = "DELETE FROM #__crudfolders
				WHERE id=$id";

		$db->setQuery($sql);

		$db->query();
	}


	public function isDuplicate ($folder_name, $curr_id){
		$db = JFactory::getDBO();

		$sql = "SELECT id 
				FROM #__crudfolders
				WHERE name = \"$folder_name\" AND id <> $curr_id";
		$db->setQuery($sql);
		
		$category_id = $db->loadObjectList();
		return (bool)sizeof($category_id);
	}
	
	public function getCategoryId($item_id)
	{
		$db = JFactory::getDBO();

		$sql = "SELECT category_id 
				FROM #__cruditems
				WHERE id = $item_id";
		$db->setQuery($sql);
		
		$category_id = $db->loadResult();
		return $category_id;
		
	}
	public function updFolder($data)
	{
		$db = JFactory::getDBO();

		$id = $data['id'];

		$item_id = $data['item_id'];
		$name = $data['folder_name'];

		if ($id) {
			//update old entry
			$sql = "UPDATE #__crudfolders
					SET name = \"$name\"
					WHERE id = $id AND item_id = $item_id";

			$db->setQuery($sql);
		} else {
			//new entry

			$sql = "INSERT INTO #__crudfolders
					(item_id, name)
					VALUES ($item_id, \"$name\")";
			$db->setQuery($sql);
		}

		if (!$db->query()) {
        	JError::raiseError(500, $db->getErrorMsg());
        	return false;
        } else {
        	return true;
		}
	}
}

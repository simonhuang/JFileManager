<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');
/**
 * JFileManager Model
 */
class JFileManagerModelCategories extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */

	public function getCategories() 
	{
		$db = JFactory::getDBO();

		$sql = "SELECT id, name
				FROM #__jfmcategories";
		$db->setQuery($sql);
		$items = $db->loadObjectList();

		return $items;
	}


	public function getCategory() 
	{
		$db = JFactory::getDBO();
		$id = JRequest::getInt('id', 0);

		$sql = "SELECT id, name
				FROM #__jfmcategories
				WHERE id = $id";
		$db->setQuery($sql);
		$items = $db->loadObject();

		return $items;
	}
	public function deleteCategory($id) 
	{
		$db = JFactory::getDBO();

		$sql = "DELETE FROM #__jfmcategories
				WHERE id=$id";
		$db->setQuery($sql);
		$db->query();
	}

	

	public function updCategory($data)
	{
		$db = JFactory::getDBO();

		$id = $data['id'];

		$name = $data['category_name'];

		if ($id) {
			//update old entry
			$sql = "UPDATE #__jfmcategories
					SET name = \"$name\"
					WHERE id = $id";

			$db->setQuery($sql);
		} else {
			//new entry

			$sql = "INSERT INTO #__jfmcategories
					(name)
					VALUES (\"$name\")";
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

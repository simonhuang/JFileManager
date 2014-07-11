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
class CrudItemsModelItems extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */

	public function getItems() 
	{
		$db = JFactory::getDBO();

		$category_id = JRequest::getInt('category_id', 0);

		$sql = "SELECT id, title, content
				FROM #__cruditems
				WHERE category_id = $category_id";

		$db->setQuery($sql);

		$items = $db->loadObjectList();

		return $items;
	}

	public function getItem() 
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0);

		$sql = "SELECT id, category_id, title, content
				FROM #__cruditems
				WHERE id=$id";

		$db->setQuery($sql);

		$items = $db->loadObject();

		return $items;
	}

	public function getName()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('category_id', 0);

		$sql = "SELECT name
				FROM #__crudcategories
				WHERE id=$id";

		$db->setQuery($sql);

		$category_name = $db->loadResult();

		return $category_name;
	}

	public function deleteItem($id)
	{
		$db = JFactory::getDBO();

		$sql = "DELETE FROM #__cruditems
				WHERE id=$id";
		$db->setQuery($sql);
		$db->query();
	}

	

	public function updItem($data)
	{
		$db = JFactory::getDBO();

		$id = $data['id'];

		$category_id = $data['category_id'];
		$title = $data['item_title'];
		$content = $data['item_content'];

		if ($id) {
			//update old entry
			$sql = "UPDATE #__cruditems
					SET title = \"$title\",
					content = \"$content\"
					WHERE id = $id AND category_id = $category_id";

			$db->setQuery($sql);
		} else {
			//new entry

			$sql = "INSERT INTO #__cruditems
					(category_id, title, content)
					VALUES ($category_id, \"$title\", \"$content\")";
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
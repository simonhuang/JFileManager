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
class JFileManagerModelItems extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */

	private $img_dir = 'components/com_jfilemanager/assets/img/';

	public function getItems() 
	{
		$db = JFactory::getDBO();

		$category_id = JRequest::getInt('category_id', 0);

		$sql = "SELECT id, title, content, img
				FROM #__jfmitems
				WHERE category_id = $category_id";

		$db->setQuery($sql);

		$items = $db->loadObjectList();

		return $items;
	}

	public function getItem()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0);

		$sql = "SELECT id, category_id, title, content, img
				FROM #__jfmitems
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
				FROM #__jfmcategories
				WHERE id=$id";

		$db->setQuery($sql);

		$category_name = $db->loadResult();

		return $category_name;
	}

	public function deleteItem($id)
	{
		// get key objects
		$db = JFactory::getDBO();
		$folder_model = JModel::getInstance('folders', 'JFileManagerModel');

		// delete image
		$sql = "SELECT img 
				FROM #__jfmitems
				WHERE id = $id";

		$db->setQuery($sql);
		$old_img = $db->loadResult();

		unlink($this->img_dir.$old_img);

		// delete folders under item
		$folder_model->deleteFolders($id);

		$sql = "DELETE FROM #__jfmitems
				WHERE id=$id";
		$db->setQuery($sql);
		$db->query();
	}

	
	
	public function updItem($data, $file)
	{
		$db = JFactory::getDBO();

		$id = $data['id'];

		$category_id = $data['category_id'];
		$title = $data['item_title'];
		$content = $data['item_content'];

		


		if ($id) {
			//update old entry


			if ($file['name']['item_img'] != ""){
				$file_name = JFile::makeSafe($file['name']['item_img']);

				$src = $file['tmp_name']['item_img'];
				$dest = $this->img_dir.$file_name;

				$thing = JFile::upload($src, $dest);

				$sql = "SELECT img 
						FROM #__jfmitems
						WHERE id = $id";

				$db->setQuery($sql);
				$old_img = $db->loadResult();

				unlink($this->img_dir.$old_img);

				$sql = "UPDATE #__jfmitems
					SET title = \"$title\",
					content = \"$content\",
					img = \"$file_name\"
					WHERE id = $id AND category_id = $category_id";
			
				$db->setQuery($sql);
			} else {
				$sql = "UPDATE #__jfmitems
					SET title = \"$title\",
					content = \"$content\"
					WHERE id = $id AND category_id = $category_id";
			
				$db->setQuery($sql);
			}
		} else {
			//new entry
			if ($file['name']['item_img'] != ""){
				$file_name = JFile::makeSafe($file['name']['item_img']);

				$src = $file['tmp_name']['item_img'];
				$dest = $this->img_dir.'/'.$file_name;

				JFile::upload($src, $dest);


				$sql = "INSERT INTO #__jfmitems
						(category_id, title, content, img)
						VALUES ($category_id, \"$title\", \"$content\", \"$file_name\")";
				$db->setQuery($sql);
			} else {
				$sql = "INSERT INTO #__jfmitems
						(category_id, title, content)
						VALUES ($category_id, \"$title\", \"$content\")";
				$db->setQuery($sql);
			}
		}

		if (!$db->query()) {
        	JError::raiseError(500, $db->getErrorMsg());
        	return false;
        } else {
        	return true;
		}
	}
}

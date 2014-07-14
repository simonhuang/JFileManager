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
class CrudItemsModelFiles extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	private $files_dir = 'components/com_cruditems/assets/files/';

	//helper functions
	public function getCategoryId($folder_id)
	{
		$db = JFactory::getDBO();


		$sql = "SELECT item_id 
				FROM #__crudfolders
				WHERE id = $folder_id";
		$db->setQuery($sql);

		$item_id = $db->loadResult();

		$sql = "SELECT category_id 
				FROM #__cruditems
				WHERE id = $item_id";
		$db->setQuery($sql);
		
		$category_id = $db->loadResult();
		return $category_id;
		
	}
	private function getFolderName($id){

		$db = JFactory::getDBO();

		$sql = "SELECT name FROM #__crudfolders
				WHERE id=$id";

		$db->setQuery($sql);

		$name = $db->loadResult();

		return $name;
	}


	//core functions
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

		$folder_name = $this->getFolderName($id);

		$sql = "DELETE FROM #__crudfolders
				WHERE id=$id";

		$db->setQuery($sql);

		$db->query();


		
		$this->deleteDir($folder_name, true);
	}

	public function addFile($data, $file)
	{
		$db = JFactory::getDBO();

		$folder_id = $data['folder_id'];
		$folder_name = $this->getFolderName($folder_id);


		$filename = JFile::makeSafe($file['name']['file']);

		$src = $file['tmp_name']['file'];
		$dest = $this->files_dir.$folder_name.'/'.$filename;

		JFile::upload($src, $dest);

		$sql = "INSERT INTO #__crudfiles
				(folder_id, name)
				VALUES ($folder_id, \"$filename\")";
		$db->setQuery($sql);

		if (!$db->query()) {
        	JError::raiseError(500, $db->getErrorMsg());
        	return false;
        } else {
        	return true;
		}
	}
}

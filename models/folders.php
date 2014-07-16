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
class JFileManagerModelFolders extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */

	private $files_dir = 'components/com_jfilemanager/assets/files/';

	//helper functions
	private function deleteDir($dir_path, $is_root) {
		if ($is_root) $dir_path = $this->files_dir.$dir_path;

	    if (! is_dir($dir_path)) {
	        throw new InvalidArgumentException("$dir_path must be a directory");
	    }
	    $files = glob($dir_path . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::deleteDir($file, false);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dir_path);
	}
	private function renameDir($dir_path, $new_dir_path) {
	    rename ($this->files_dir.$dir_path, $this->files_dir.$new_dir_path);
	}
	private function createDir($dir_path) {
	    mkdir($this->files_dir.$dir_path, 0777, true);
	}


	public function generatePath($name, $folder_id){
		
		// initilize variables
		$db = JFactory::getDBO();
		$path = '';
		$parent_id = $folder_id;


		// loop until we get to the document root to get the path
		$isRoot = false;
		do {

			// if there is no parent break loop
			if (!$folder_id){
				break;
			}

			// get parent folder to determine if it is a root
			$sql = "SELECT name, item_id, folder_id FROM #__jfmfolders
					WHERE id=$parent_id"; 

			$db->setQuery($sql);
			$folder = $db->loadObject();

			// update path
			$path = $folder->name.'/'.$path;


			if ($folder->item_id){
				// if there is an item_id then it is the root
				$isRoot = true;
			} else {
				// or else move onto the next folder
				$parent_id = $folder->folder_id;
			}
		} while (!$isRoot);

		return $path;
	}



	private function getFolderName($id){

		$db = JFactory::getDBO();

		$sql = "SELECT name FROM #__jfmfolders
				WHERE id=$id";

		$db->setQuery($sql);

		$name = $db->loadResult();

		return $name;
	}


	//core functions
	public function getRootFolders($item_id) 
	{
		$db = JFactory::getDBO();

		$sql = "SELECT id, name
				FROM #__jfmfolders
				WHERE item_id = $item_id";

		$db->setQuery($sql);

		$folders = $db->loadObjectList();

		return $folders;
	}

	public function getFolders($folder_id)
	{
		$db = JFactory::getDBO();

		$sql = "SELECT id, name
				FROM #__jfmfolders
				WHERE folder_id = $folder_id";

		$db->setQuery($sql);

		$folders = $db->loadObjectList();

		return $folders;
	}

	public function getFolder()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0) ;

		$sql = "SELECT id, item_id, folder_id, name
				FROM #__jfmfolders
				WHERE id = $id";

		$db->setQuery($sql);

		$folder = $db->loadObject();

		return $folder;
	}

	public function deleteFolder($id)
	{
		$db = JFactory::getDBO();

		$sql = "DELETE FROM #__jfmfolders
				WHERE id=$id";

		$db->setQuery($sql);

		$db->query();


		$folder_name = $this->getFolderName($id);
		
		$this->deleteDir($folder_name, true);
	}


	public function isDuplicate ($folder_name, $folder_id, $id){
		$db = JFactory::getDBO();

		$sql = "SELECT id 
				FROM #__jfmfolders
				WHERE name = \"$folder_name\" AND folder_id == $folder_id AND  id <> $id";
		$db->setQuery($sql);
		
		$category_id = $db->loadObjectList();
		return (bool)sizeof($category_id);
	}
	
	public function getCategoryId($path, $item_id)
	{
		// initilize variables
		$db = JFactory::getDBO();


		if (!$item_id){
			// get the name of the root folder from the path
			$length = strpos($path, '/') ;

			$folder_name = substr($path, 0, $length);

			// get the item_id of the root folder
			$sql = "SELECT item_id 
					FROM #__jfmfolders 
					WHERE name = \"$folder_name\" AND folder_id = 0";
			$db->setQuery($sql);
			$item_id = $db->loadResult();
		}

		// get the category that the item is in
		$sql = "SELECT category_id 
				FROM #__jfmitems
				WHERE id = $item_id";
		$db->setQuery($sql);
		
		$category_id = $db->loadResult();
		return $category_id;
		
	}
	public function updFolder($data, $path)
	{
		$db = JFactory::getDBO();

		$id = $data['id'];

		$item_id = $data['item_id'];
		$folder_id = $data['folder_id'];
		$name = $data['folder_name'];


		if ($id) {
			//update old entry

			$old_name = $this->getFolderName($id);

			$this->renameDir($path.$old_name, $path.$name);

			$sql = "UPDATE #__jfmfolders
					SET name = \"$name\
					WHERE id = $id";

			$db->setQuery($sql);
		} else {
			//new entry
			$this->createDir($path.$name);

			$sql = "INSERT INTO #__jfmfolders
					(item_id, folder_id, name)
					VALUES ($item_id, $folder_id, \"$name\")";
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

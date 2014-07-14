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
	private function getFileName($id){

		$db = JFactory::getDBO();

		$sql = "SELECT name FROM #__crudfiles
				WHERE id=$id";

		$db->setQuery($sql);

		$name = $db->loadResult();

		return $name;
	}


	//core functions
	public function getFiles($folder_id) 
	{
		$db = JFactory::getDBO();

		$sql = "SELECT id, name
				FROM #__crudfiles
				WHERE folder_id = $folder_id";

		$db->setQuery($sql);

		$files = $db->loadObjectList();

		return $files;
	}

	public function downloadFile()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0);

		$sql = "SELECT name, folder_id
				FROM #__crudfiles
				WHERE id = $id";

		$db->setQuery($sql);

		$result = $db->loadObject();

		$folder_name = $this->getFolderName($result->folder_id);

		$file = $this->files_dir.$folder_name.'/'.$result->name;

		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; file_name='.basename($file));
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    ob_clean();
		    flush();
		    readfile($file);
		    exit;
		}
	}

	public function deleteFile()
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0);

		$sql = "SELECT name, folder_id
				FROM #__crudfiles
				WHERE id = $id";

		$db->setQuery($sql);

		$result = $db->loadObject();

		$file_name = $result->name;
		$folder_name = $this->getFolderName($result->folder_id);

		unlink($this->files_dir.$folder_name.'/'.$file_name);


		$sql = "DELETE FROM #__crudfiles
				WHERE id=$id";

		$db->setQuery($sql);

		$db->query();
	}

	public function addFile($data, $file)
	{
		$db = JFactory::getDBO();

		$folder_id = $data['folder_id'];
		$folder_name = $this->getFolderName($folder_id);


		$file_name = JFile::makeSafe($file['name']['file']);

		$src = $file['tmp_name']['file'];
		$dest = $this->files_dir.$folder_name.'/'.$file_name;

		JFile::upload($src, $dest);

		$sql = "INSERT INTO #__crudfiles
				(folder_id, name)
				VALUES ($folder_id, \"$file_name\")";
		$db->setQuery($sql);

		if (!$db->query()) {
        	JError::raiseError(500, $db->getErrorMsg());
        	return false;
        } else {
        	return true;
		}
	}
}
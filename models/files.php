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
class JFileManagerModelFiles extends JModelItem
{


	/**
	 * Get the message
	 * @return object The message to be displayed to the user
	 */
	private $files_dir = 'components/com_jfilemanager/assets/files/';

	//helper functions
	public function getCategoryId($folder_id)
	{
		$db = JFactory::getDBO();


		$sql = "SELECT item_id 
				FROM #__jfmfolders
				WHERE id = $folder_id";
		$db->setQuery($sql);

		$item_id = $db->loadResult();

		$sql = "SELECT category_id 
				FROM #__jfmitems
				WHERE id = $item_id";
		$db->setQuery($sql);
		
		$category_id = $db->loadResult();
		return $category_id;
		
	}
	private function getFileName($id){

		$db = JFactory::getDBO();

		$sql = "SELECT name FROM #__jfmfiles
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
				FROM #__jfmfiles
				WHERE folder_id = $folder_id";

		$db->setQuery($sql);

		$files = $db->loadObjectList();

		return $files;
	}

	public function downloadFile($path)
	{
		$db = JFactory::getDBO();

		$id = JRequest::getInt('id', 0);

		$sql = "SELECT name, folder_id
				FROM #__jfmfiles
				WHERE id = $id";

		$db->setQuery($sql);

		$result = $db->loadObject();

		$file = $this->files_dir.$path.'/'.$result->name;


		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename='.basename("$file"));
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

	public function deleteFile($id, $file_name, $path)
	{
		$db = JFactory::getDBO();

		unlink($this->files_dir.$path.$file_name);


		$sql = "DELETE FROM #__jfmfiles
				WHERE id=$id";

		$db->setQuery($sql);

		$db->query();
	}

	public function deleteFiles($folder_id, $folder_name)
	{
		// get database object
		$db = JFactory::getDBO();


		// delete files from database
		$sql = "DELETE FROM #__jfmfiles
				WHERE folder_id = $folder_id";

		$db->setQuery($sql);

		$db->query();
	}

	public function addFile($data, $file, $path)
	{
		$db = JFactory::getDBO();

		$folder_id = $data['folder_id'];


		$file_name = JFile::makeSafe($file['name']['file']);

		$src = $file['tmp_name']['file'];
		$dest = $this->files_dir.$path.'/'.$file_name;

		$thing = JFile::upload($src, $dest);

		$sql = "INSERT INTO #__jfmfiles
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
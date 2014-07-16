<?php
	// get the current folder
	$item = $this->items[$this->item_count];
	$folders = $item->folders;

	foreach ($this->traverse as $nth_folder){
		$folder = $folders[$nth_folder];
		$folders = $folder->folders;
	}

	$unique_id = 'subfolders'.implode('', $this->traverse);
?>
<div class="panel-group" id="accordion<?php echo $index; ?>">

	<?php foreach($folders as $i => $f):  ?>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion<?php echo $unique_id; ?>" href="#collapse<?php echo $i.'in'.$unique_id;?>">
		          	Folder: <?php echo $f->name; ?>
		        </a>
			</h4>
		</div>

		<div id="collapse<?php echo $i.'in'.$unique_id;?>" class="panel-collapse collapse">
			<div class="panel-body">

				<?php foreach($f->files as $file): ?>
					<p>
						<a class="btn btn-info" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=files.downloadFile&id='.$file->id);?>">
						<?php echo $file->name; ?>
						</a>
						<a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=files.delete
							&id='.$file->id.'
							&file_name='.$file->name.'
							&folder_id='.$f->id.'
							&folder_name='.$f->name);?>">
						Delete File
						</a>
					</p>

				<?php endforeach; ?>



				<?php
				array_push($this->traverse, $i);

				if (sizeof($f->folders)) echo $this->loadTemplate('folders'); 

				array_pop($this->traverse);
				?>


				<a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=files&layout=edit&folder_id='.$f->id);?>">Add File</a>
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&id='.$f->id);?>">Edit Folder</a>
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=folders.delete
					&id='.$f->id.'
					&folder_name='.$f->name.'
					&category_id='.$this->category_id);?>">Delete Folder</a>
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&folder_id='.$f->id);?>">Add Folder</a>
			</div>
		</div>
	</div>	
	<?php endforeach;?>

</div>
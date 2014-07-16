<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<section class="bootstrap">
<h2 class="jfm-header"><?php echo $this->header ?></h2>

<section class="main-actions">
	<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=items&layout=edit&category_id='.$this->category_id);?>">Add New Item</a>
	<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=categories');?>">Back to Categories</a>
</section>

<?php
	$items = $this->items;
	foreach ($items as $index => $item):
		$this->item_count = $index;
	?>
	<article class="jfm-item">
		<div class="img">
			<?php //echo $item->id;?>
			<img src="components/com_jfilemanager/assets/img/<?php echo $item->img; ?>">
		</div>
		<div class="desc">
			<h3><?php echo $item->title;?></h3>

			<p><?php echo $item->content;?></p>

			<div class="panel-group" id="accordion<?php echo $index; ?>">

				<?php foreach($item->folders as $i => $folder):  ?>

				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#accordion<?php echo $index; ?>" href="#collapse<?php echo $i.'in'.$index;?>">
					          	Folder: <?php echo $folder->name; ?>
					        </a>
						</h4>
					</div>

					<div id="collapse<?php echo $i.'in'.$index;?>" class="panel-collapse collapse">
						<div class="panel-body">

							<?php foreach($folder->files as $file): ?>
								<p>
									<a class="btn btn-info" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=files.downloadFile&id='.$file->id);?>">
									<?php echo $file->name; ?>
									</a>
									<a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=files.delete
										&id='.$file->id.'
										&file_name='.$file->name.'
										&folder_id='.$folder->id.'
										&folder_name='.$folder->name);?>">
									Delete File
									</a>
								</p>

							<?php endforeach; ?>

							<?php 
							// update traverse stack and render template (so it knows where to go to look for the folder to render)
							array_push($this->traverse, $i);

							echo $this->loadTemplate('folders'); 

							array_pop($this->traverse);
							?>
							<a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=files&layout=edit&folder_id='.$folder->id);?>">Add File</a>
							<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&id='.$folder->id);?>">Edit Folder</a>
							<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=folders.delete
								&id='.$folder->id.'
								&folder_name='.$folder->name.'
								&category_id='.$this->category_id);?>">Delete Folder</a>
							<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&folder_id='.$folder->id);?>">Add Folder</a>
						</div>
					</div>
				</div>	
				<?php endforeach;?>

			</div>

			<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=items&layout=edit&id='.$item->id);?>">Edit</a>
			<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=items.delete
			&id='.$item->id.'
			&category_id='.$this->category_id);?>">Delete</a>
			<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=folders&layout=edit&item_id='.$item->id);?>">Add Folder</a>
		</div>	
	</article>
<?php endforeach; ?>
</section>
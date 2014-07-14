<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<section class="container">
<h2><?php echo $this->header ?></h2>

<section class="main-actions">
	<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=items&layout=edit&category_id='.$this->category_id);?>">Add New Item</a>
	<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=categories');?>">Back to Categories</a>
</section>

<?php
	$items = $this->items;
	foreach ($items as $index => $item):
	?>
		<article class="row">
			<div class="col-xs-2">
				<?php echo $item->id;?>
				<img src="components/com_cruditems/assets/img/<?php echo $item->img; ?>">
			</div>
			<div class="col-xs-6">
				<?php echo $item->title;?>
				<br>

				<?php echo $item->content;?>
				<br>

				<div class="panel-group" id="accordion<?php echo $index; ?>">

				<?php foreach($item->folders as $i => $folder):  ?>

					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion<?php echo $index; ?>" href="#collapse<?php echo $i;?>">
						          	Folder: <?php echo $folder->name; ?>
						        </a>
							</h4>
						</div>

						<div id="collapse<?php echo $i;?>" class="panel-collapse collapse">
							<div class="panel-body">
								<?php foreach($folder->files as $file): ?>
									<p>
										<a class="btn btn-info" href="<?php echo JRoute::_('index.php?option=com_cruditems&task=files.downloadFile&id='.$file->id);?>">
										<?php echo $file->name; ?>
										</a>
										<a class="btn btn-danger" href="<?php echo JRoute::_('index.php?option=com_cruditems&task=files.delete
											&id='.$file->id.'
											&folder_id='.$folder->id);?>">
										Delete File
										</a>
									</p>

								<?php endforeach; ?>
								<a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=files&layout=edit&folder_id='.$folder->id);?>">Add File</a>
								<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=folders&layout=edit&id='.$folder->id);?>">Edit Folder</a>
								<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&task=folders.delete
									&id='.$folder->id.'
									&category_id='.$this->category_id);?>">Delete Folder</a>
							</div>
						</div>
					</div>	
				<?php endforeach;?>

				</div>

			</div>
			<div class="col-xs-4">
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=items&layout=edit&id='.$item->id);?>">Edit</a>
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&task=items.delete
				&id='.$item->id.'
				&category_id='.$this->category_id);?>">Delete</a>
				<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=folders&layout=edit&item_id='.$item->id);?>">+ Folder</a>
			</div>
			
		</article>
	<?php
	endforeach;
?>
</section>
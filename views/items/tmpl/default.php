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
	foreach ($items as $index => $item) :
	?>
		<article class="row">
			<div class="col-xs-2">
				<?php echo $item->id;?>
			</div>
			<div class="col-xs-6">
				<?php echo $item->title;?>
				<br>

				<?php echo $item->content;?>
				<br>

				<?php
					foreach($item->folders as $i => $folder):
					?>
						<p>
							Folder: <?php echo $folder->name; ?>
							<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=folders&layout=edit&id='.$folder->id);?>">Edit Folder</a>
							<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&task=folders.delete
								&id='.$folder->id.'
								&category_id='.$this->category_id);?>">Delete Folder</a>
						</p>	
					<?php
					endforeach;
				?>
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
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<section class="bootstrap">
<h2><?php echo $this->header ?></h2>

<section class="main-actions">
	<a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=categories&layout=edit');?>">Add New Category</a>
</section>

<table class="table">
	<thead>
		<tr>
			<th>Category ID</th>
			<th>Category Name</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		$categories = $this->categories;
		foreach ($categories as $index => $category): 
		?>

			<tr>
				<td><?php echo $category->id;?></td>
				<td>
					<a class="btn btn-info" 
						href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=items&category_id='.$category->id);?>">
						<?php echo $category->name;?>
					</a>
				</td>
				<td>
					<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&view=jfilemanager&layout=edit&id='.$category->id);?>">Edit</a>
					<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_jfilemanager&task=jfilemanager.delete&id='.$category->id);?>">Delete</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
</section>
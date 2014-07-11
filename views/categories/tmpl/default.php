<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<section class="container">
<h2><?php echo $this->header ?></h2>

<section class="main-actions">
	<a class="btn btn-success" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=categories&layout=edit');?>">Add New Category</a>
</section>
<?php
	$categories = $this->categories;
	foreach ($categories as $index => $category) {
		?>
			<article class="row">
				<div class="col-xs-2">
					<?php echo $category->id;?>
				</div>
				<div class="col-xs-6">
					<a class="btn btn-primary" 
						href="<?php echo JRoute::_('index.php?option=com_cruditems&view=items&category_id='.$category->id);?>">
						<?php echo $category->name;?>
					</a>
				</div>
				<div class="col-xs-4">
					<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&view=categories&layout=edit&id='.$category->id);?>">Edit</a>
					<a class="btn btn-primary" href="<?php echo JRoute::_('index.php?option=com_cruditems&task=categories.delete&id='.$category->id);?>">Delete</a>
				</div>
				
			</article>
		<?php
	}
?>
</section>
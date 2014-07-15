<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

?>

<section class="bootstrap">
<h2><?php echo $this->header ?></h2>
<form autocomplete="on" class="form-horizontal" role="form" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="category" name="category" data-parsley-validate data-parsley-focus="none">
    <div class="form-group">
        <label for="category_name" class="col-md-2 control-label">Name *</label>
        <div class="col-md-10">
            <input required value="<?php echo $this->name; ?>" class="form-control" name="jform[category_name]" id="category_name" placeholder="Category Name" />
        </div>
    </div>

    

    <input type="hidden" name="jform[id]" value="<?php echo $this->id; ?>" />

    <input type="hidden" name="option" value="com_jfilemanager" />
    <input type="hidden" name="task" value="categories.submit" />

    

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
          <button type="submit" class="btn btn-success validate">Save</button>
          <a class="btn btn-success" href="<?php echo JRoute::_('timesheet');?>">Cancel</a>
        </div>
    </div>
    <div class="invalid-form-error-message"></div>

    <?php echo JHtml::_('form.token'); ?>
</form>
</section>
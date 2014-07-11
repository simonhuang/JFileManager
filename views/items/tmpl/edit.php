<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

?>


<h2><?php echo $this->header ?></h2>
<form autocomplete="on" class="form-horizontal" role="form" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="item" name="item" data-parsley-validate data-parsley-focus="none">
    <div class="form-group">
        <label for="item_title" class="col-md-2 control-label">Title *</label>
        <div class="col-md-10">
            <input required value="<?php echo $this->title; ?>" class="form-control" name="jform[item_title]" id="item_title" placeholder="Item Title" />
        </div>
    </div>

    <div class="form-group">
        <label for="item_content" class="col-md-2 control-label">Content</label>
        <div class="col-md-10">
            <input value="<?php echo $this->content; ?>" class="form-control" name="jform[item_content]" id="item_content" placeholder="Item Content" />
        </div>
    </div>

    

    <input type="hidden" name="jform[id]" value="<?php echo $this->id; ?>" />
    <input type="hidden" name="jform[category_id]" value="<?php echo $this->category_id; ?>" />

    <input type="hidden" name="option" value="com_cruditems" />
    <input type="hidden" name="task" value="items.submit" />

    

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
          <button type="submit" class="btn btn-success validate">Save</button>
          <a class="btn btn-success" href="<?php echo JRoute::_('timesheet');?>">Cancel</a>
        </div>
    </div>
    <div class="invalid-form-error-message"></div>

    <?php echo JHtml::_('form.token'); ?>
</form>

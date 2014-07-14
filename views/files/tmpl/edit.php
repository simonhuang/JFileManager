<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

?>


<h2><?php echo $this->header ?></h2>
<form autocomplete="on" class="form-horizontal" role="form" action="<?php echo JRoute::_('index.php'); ?>" method="post" id="file" name="file" enctype="multipart/form-data" data-parsley-validate data-parsley-focus="none">
    <div class="form-group">
        <label for="file" class="col-md-2 control-label">Name *</label>
        <div class="col-md-10">
            <input required type="file" value="<?php echo $this->name; ?>" class="form-control" name="jform[file]" id="file_name" placeholder="File Name" />
        </div>
    </div>

    

    <input type="hidden" name="jform[id]" value="<?php echo $this->id; ?>" />
    <input type="hidden" name="jform[folder_id]" value="<?php echo $this->folder_id; ?>" />

    <input type="hidden" name="option" value="com_cruditems" />
    <input type="hidden" name="task" value="files.submit" />

    

    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
          <button type="submit" class="btn btn-success validate">Save</button>
          <a class="btn btn-success" href="<?php echo JRoute::_('timesheet');?>">Cancel</a>
        </div>
    </div>
    <div class="invalid-form-error-message"></div>

    <?php echo JHtml::_('form.token'); ?>
</form>

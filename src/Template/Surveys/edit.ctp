<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $survey
 */
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Create {0}', ['Survey']);?></h4>
        </div>
    </div>
</section>
<section class="content">
    <?= $this->Form->create($survey) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Details');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('name'); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('category', ['options' => $categories]); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('description');?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('active'); ?>
                </div>
            </div>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>

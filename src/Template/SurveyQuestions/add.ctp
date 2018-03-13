<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyQuestion
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
    <?= $this->Form->create($surveyQuestion) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Details');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('survey_id', ['options' => $surveys]); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('question'); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->control('active'); ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</section>

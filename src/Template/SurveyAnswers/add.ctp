<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyChoice
 */
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Create {0}', ['Question Option']);?></h4>
        </div>
    </div>
</section>
<section class="content">
<div class="surveyChoices form large-9 medium-8 columns content">
    <?= $this->Form->create($surveyAnswer) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Details');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('survey_question_id', ['options' => $surveyQuestions]); ?>
                    <?php echo $this->Form->input('answer'); ?>
                    <?php echo $this->Form->input('comment'); ?>
                </div>
            </div>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</section>

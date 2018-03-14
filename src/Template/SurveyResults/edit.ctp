<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyAnswer
 */
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Create {0}', ['Answer']);?></h4>
        </div>
    </div>
</section>
<section class="content">
<div class="surveyAnswers form large-9 medium-8 columns content">
    <?= $this->Form->create($surveyResult) ?>
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
                    <?php echo $this->Form->input('survey_question_id', ['options' => $surveyQuestions]); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('survey_answer_id', ['options' => $surveyAnswers]); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('user_id', ['options' => $users]); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->input('result'); ?>
                </div>
            </div>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
</div>
</section>

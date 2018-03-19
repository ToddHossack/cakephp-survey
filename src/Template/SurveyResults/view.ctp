<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyResult
 */
$options['title'] = 'View Question Result';
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
            </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Details'); ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
             <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Id') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyResult->id) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
             <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Survey') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyResult->has('survey') ? $this->Html->link($surveyResult->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyResult->survey->id]) : '' ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
             <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Survey Question') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyResult->has('survey_question') ? $this->Html->link($surveyResult->survey_question->question, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyResult->survey_question->id]) : '' ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
             <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Survey Answer') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyResult->has('survey_answer') ? $this->Html->link($surveyResult->survey_answer->answer, ['controller' => 'SurveyAnswers', 'action' => 'view', $surveyResult->survey_answer->id]) : '' ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Result') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $this->Text->autoParagraph(h($surveyResult->result)); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('User') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyResult->has('user') ? $this->Html->link($surveyResult->user->username, ['controller' => 'Users', 'action' => 'view', $surveyResult->user->id]) : '' ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Created') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyResult->created) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Modified') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyResult->modified) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
          </div>
    </div>
</section>

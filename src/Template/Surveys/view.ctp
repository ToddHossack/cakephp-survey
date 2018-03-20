<?php
use Cake\Core\Configure;

$options['title'] = 'View Surveys';

echo $this->Html->scriptBlock('var apiToken="' . Configure::read('API.token') . '";', ['block' => 'scriptBottom']);
echo $this->Html->css([
    'AdminLTE./plugins/morris/morris',
], [
    'block' => 'scriptBottom'
]);

echo $this->Html->script([
    'Qobo/Survey.raphael-min',
    'AdminLTE./plugins/morris/morris.min',
    'Qobo/Survey.init',
    ], [
        'block' => 'scriptBottom'
    ]
);
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
                    <?= h($survey->id) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Name') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($survey->name) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Version') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($survey->version) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Created') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($survey->created) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Active') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $survey->active ? __('Yes') : __('No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Description') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $this->Text->autoParagraph(h($survey->description)); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
        </div>
    </div>

    <?php $count = 1;?>
    <?php foreach ($survey->survey_questions as $k => $question) : ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $count . '. ' . $question->question;?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row survey-question-results" data-id="<?= $question->id?>" data-survey-id="<?= $survey->id ?>">
                <div class="col-xs-12 col-md-6">
                    <?php if (!in_array($question->type, ['input', 'textarea'])) : ?>
                    <ul>
                    <?php foreach ($question->survey_answers as $answer) : ?>
                        <li data-answer-id="<?= $answer->id?>"><?= $answer->answer; ?>. <strong>(Total: <span class="answer-stats"></span>)</strong></li>
                    <?php endforeach; ?>
                    </ul>
                    <?php else : ?>
                        <p> Question is [<?= $question->type ?>] type. <?= $this->Html->link(__('Load Answers'), '#', ['action' => 'view', 'controller' => 'SurveyResults']);?></p>
                    <?php endif; ?>
                </div>
                <div class="col-xs-12 col-md-5 graphs-container" id="graph-<?= $question->id ?>" data-question-type="<?= $question->type ?>" style="height:200px;width:200px;">
                    <!-- graphs content goes here.. -->
                </div>
            </div>
        </div>
    </div>
    <?php $count++; ?>
    <?php endforeach; ?>
</section>

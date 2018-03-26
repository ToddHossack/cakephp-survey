<?php
/**
 * Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Qobo Ltd. (https://www.qobo.biz)
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

$table = TableRegistry::get($this->name);

$options['title'] = 'View Surveys';

echo $this->Html->scriptBlock('var apiToken="' . Configure::read('API.token') . '";', ['block' => 'scriptBottom']);
echo $this->Html->css([
    'AdminLTE./plugins/morris/morris',
], [
    'block' => 'scriptBottom'
]);

echo $this->Html->script(
    [
        'Qobo/Survey.raphael-min',
        'AdminLTE./plugins/morris/morris.min',
        'Qobo/Survey.init',
    ],
    [
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
                    <strong><?= __('ID') ?>:</strong>
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

    <div class="nav-tabs-custom">
        <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="#manage-survey-questions" aria-controls="manage-content" role="tab" data-toggle="tab">
                    <?= __('Questions'); ?>
                </a>
            </li>
            <li role="presentation">
                 <a href="#manage-survey-answers" aria-controls="manage-content" role="tab" data-toggle="tab">
                    <?= __('Answers'); ?>
                </a>
            </li>
            <li role="presentation">
                <a href="#manage-survey-results" aria-controls="manage-survey-results" role="tab" data-toggle="tab">
                    <?= __('Survey Results'); ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="manage-survey-questions">
                <?= $this->element('Qobo/Survey.SurveyQuestions/view', ['survey' => $survey]);?>
            </div>
            <div role="tabpanel" class="tab-pane" id="manage-survey-answers">
                <?= $this->element('Qobo/Survey.Answers/view', ['survey' => $survey]);?>
            </div>
            <div role="tabpanel" class="tab-pane" id="manage-survey-results">
                <?= $this->element('Qobo/Survey.SurveyResults/view', ['survey' => $survey]);?>
            </div>
        </div>
    </div>

</section>

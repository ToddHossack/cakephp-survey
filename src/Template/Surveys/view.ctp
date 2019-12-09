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

echo $this->Html->scriptBlock('var apiToken="' . Configure::read('API.token') . '";', ['block' => 'scriptBottom']);
echo $this->Html->css([
    'AdminLTE./bower_components/morris.js/morris',
], [
    'block' => 'scriptBottom'
]);

echo $this->Html->script(
    [
        'Qobo/Survey.raphael-min',
        'AdminLTE./bower_components/morris.js/morris.min',
        'Qobo/Survey.init',
    ],
    [
        'block' => 'scriptBottom'
    ]
);

$surveyId = !empty($survey->slug) ? $survey->slug : $survey->id;

$options['title'] = __d('Qobo/Survey',
    '{0} &raquo; {1}',
    $this->Html->link(__d('Qobo/Survey', 'Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $survey->get('name')
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
                <?= $this->Form->postLink(
                    '<i class="fa fa-clipboard"></i> ' . __d('Qobo/Survey', 'Copy'),
                    ['action' => 'duplicate', $survey->id],
                    ['escape' => false, 'class' => 'btn btn-default', 'title' => __d('Qobo/Survey', 'Duplicate whole survey')]
                ); ?>
                <?= $this->Html->link(
                    '<i class="fa fa-file"></i> ' . __d('Qobo/Survey', 'Preview'),
                    ['plugin' => 'Qobo/Survey', 'controller' => 'Surveys', 'action' => 'preview', $surveyId],
                    ['class' => 'btn btn-default', 'escape' => false]
                ); ?>
                <?php if (empty($survey->publish_date)) : ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-calendar"></i> ' . __d('Qobo/Survey', 'Publish'),
                        ['plugin' => 'Qobo/Survey', 'controller' => 'Surveys', 'action' => 'publish', $surveyId],
                        ['class' => 'btn btn-default', 'escape' => false]
                    )?>
                    <?= $this->Html->link(
                        '<i class="fa fa-pencil"></i> ' . __d('Qobo/Survey', 'Edit'),
                        ['plugin' => 'Qobo/Survey', 'controller' => 'Surveys', 'action' => 'edit', $surveyId],
                        ['class' => 'btn btn-default', 'escape' => false]
                    ); ?>
                <?php endif; ?>
                <?= $this->Form->postLink(
                    '<i class="fa fa-trash"></i> ' . __d('Qobo/Survey', 'Delete'),
                    ['plugin' => 'Qobo/Survey', 'controller' => 'Surveys', 'action' => 'delete', $survey->id],
                    ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __d('Qobo/Survey', 'Are you sure you want to delete # {0}', $survey->name)]
                ); ?>
            </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
       <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __d('Qobo/Survey', 'Details'); ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Name') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($survey->name) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'ID') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($survey->id) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Slug') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($survey->slug) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Publish Date') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= empty($survey->publish_date) ? 'N/A' : $survey->publish_date->i18nFormat('yyyy-MM-dd HH:mm') ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Description') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $this->Text->autoParagraph(h($survey->description)); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Active') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $survey->active ? __d('Qobo/Survey', 'Yes') : __d('Qobo/Survey', 'No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Expiry Date') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= empty($survey->expiry_date) ? 'N/A' : $survey->expiry_date->i18nFormat('yyyy-MM-dd HH:mm') ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="#manage-survey-sections" aria-controls="manage-content" role="tab" data-toggle="tab">
                    <i class="fa fa-list-ul"></i> <i class="fa question-circle"></i> <?= __d('Qobo/Survey', 'Sections'); ?>
                </a>
            </li>
            <li role="presentation">
                <a href="#manage-survey-entries" aria-controls="manager-survey-entries" role="tab" data-toggle="tab">
                    <i class="fa fa-signal"></i> <?= __d('Qobo/Survey', 'Entries') ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="manage-survey-sections">
                <?= $this->element('Qobo/Survey.SurveySections/view', ['survey' => $survey]) ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="manage-survey-entries">
                <?= $this->element('Qobo/Survey.SurveyEntries/view', ['survey' => $survey]) ?>
            </div>
        </div>
    </div>

</section>

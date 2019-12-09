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
$surveyId = empty($survey->get('slug')) ? $survey->get('id') : $survey->get('slug');

$options['title'] = __d('Qobo/Survey',
    '{0} &raquo; {1} &raquo; "{2}" question',
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]),
    $this->Html->link(__d('Qobo/Survey', 'Current Section'), ['controller' => 'SurveySections', 'action' => 'view', $survey->get('id'), $surveyQuestion->get('survey_section_id')]),
    $surveyQuestion->get('question')
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
            <?= $this->Html->link(
                '<i class="fa fa-file"></i> ' . __d('Qobo/Survey', 'Preview'),
                ['controller' => 'SurveyQuestions', 'action' => 'preview', $surveyId, $surveyQuestion->get('id')],
                ['class' => 'btn btn-default', 'title' => __d('Qobo/Survey', 'Preview'), 'escape' => false]
            )?>
            <?php if (empty($survey->get('publish_date'))) : ?>
                <?= $this->Html->link(
                    '<i class="fa fa-pencil"></i> ' . __d('Qobo/Survey', 'Edit'),
                    ['controller' => 'SurveyQuestions', 'action' => 'edit', $surveyId, $surveyQuestion->get('id')],
                    ['class' => 'btn btn-default', 'title' => __d('Qobo/Survey', 'Edit'), 'escape' => false]
                )?>
                <?= $this->Form->postLink(
                    '<i class="fa fa-trash"></i> ' . __d('Qobo/Survey', 'Delete'),
                    ['controller' => 'SurveyQuestions', 'action' => 'delete', $surveyId, $surveyQuestion->get('id')],
                    ['class' => 'btn btn-default', 'title' => __d('Qobo/Survey', 'Delete'), 'escape' => false, 'confirm' => __d('Qobo/Survey', 'Are you sure you want to delete # {0}?', $surveyQuestion->get('id'))]
                )?>
            <?php endif; ?>
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
                    <strong><?= __d('Qobo/Survey', 'ID') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->get('id')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Survey') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Type') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $questionTypes[$surveyQuestion->get('type')] ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Active') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyQuestion->get('active') ? __d('Qobo/Survey', 'Yes') : __d('Qobo/Survey', 'No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Required') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyQuestion->get('is_required') ? __d('Qobo/Survey', 'Yes') : __d('Qobo/Survey', 'No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Question') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $this->Text->autoParagraph(h($surveyQuestion->get('question'))); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Created') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->get('created')->i18nFormat('yyyy-MM-dd HH:mm')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Modified') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->get('modified')->i18nFormat('yyyy-MM-dd HH:mm')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
        </div>
    </div>
    <?php if (!empty($surveyQuestion->get('extras'))) : ?>
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
            <?= $surveyQuestion->get('extras') ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="nav-tabs-custom">
        <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation">
                 <a href="#manage-survey-answers" aria-controls="manage-content" role="tab" data-toggle="tab">
                    <i class="fa fa-check-circle"></i> <?= __d('Qobo/Survey', 'Answers'); ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="manage-survey-answers">
                <?= $this->element('Qobo/Survey.Answers/view', ['survey' => $surveyQuestion, 'collapsed' => true]);?>
            </div>
        </div>
    </div>
</section>

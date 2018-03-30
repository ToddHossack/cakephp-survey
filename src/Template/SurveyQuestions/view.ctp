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
$surveyId = empty($survey->slug) ? $survey->id : $survey->slug;
$options['title'] = $this->Html->link(
    $survey->name,
    ['controller' => 'Surveys', 'action' => 'view', $surveyId]
);
$options['title'] .= " &raquo; ";
$options['title'] .= $surveyQuestion->question;

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
                '<i class="fa fa-file"></i> ' . __('Preview'),
                ['controller' => 'SurveyQuestions', 'action' => 'preview', $surveyId, $surveyQuestion->id],
                ['class' => 'btn btn-default', 'title' => __('Preview'), 'escape' => false]
            )?>
            <?= $this->Html->link(
                '<i class="fa fa-pencil"></i> ' . __('Edit'),
                ['controller' => 'SurveyQuestions', 'action' => 'edit', $surveyId, $surveyQuestion->id],
                ['class' => 'btn btn-default', 'title' => __('Edit'), 'escape' => false]
            )?>
            <?= $this->Form->postLink(
                '<i class="fa fa-trash"></i> ' . __('Delete'),
                ['controller' => 'SurveyQuestions', 'action' => 'delete', $surveyId, $surveyQuestion->id],
                ['class' => 'btn btn-default', 'title' => __('Delete'), 'escape' => false, 'confirm' => __('Are you sure you want to delete # {0}?', $surveyQuestion->id)]
            )?>
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
                    <?= h($surveyQuestion->id) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Survey') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyQuestion->has('survey') ? $this->Html->link($surveyQuestion->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyQuestion->survey->id]) : '' ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
           <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Type') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $questionTypes[$surveyQuestion->type] ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Active') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $surveyQuestion->active ? __('Yes') : __('No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Question') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $this->Text->autoParagraph(h($surveyQuestion->question)); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Created') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->created->i18nFormat('yyyy-MM-dd HH:mm')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Modified') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->modified->i18nFormat('yyyy-MM-dd HH:mm')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation">
                 <a href="#manage-survey-answers" aria-controls="manage-content" role="tab" data-toggle="tab">
                    <?= __('Answers'); ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="manage-survey-answers">
                <?= $this->element('Qobo/Survey.Answers/view', ['survey' => $survey]);?>
            </div>
        </div>
    </div>
</section>

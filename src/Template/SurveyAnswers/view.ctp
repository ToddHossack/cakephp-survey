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
$options['title'] = 'View Surveys';
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
                <?= h($surveyAnswer->id) ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-md-2 text-right">
                <strong><?= __('Survey Question') ?>:</strong>
            </div>
            <div class="col-xs-8 col-md-4">
                <?= $surveyAnswer->has('survey_question') ? $this->Html->link($surveyAnswer->survey_question->id, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyAnswer->survey_question->id]) : '' ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-md-2 text-right">
                <strong><?= __('Question Type') ?>:</strong>
            </div>
            <div class="col-xs-8 col-md-4">
                <?= h($surveyAnswer->type) ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-md-2 text-right">
                <strong><?= __('Created') ?>:</strong>
            </div>
            <div class="col-xs-8 col-md-4">
                <?= h($surveyAnswer->created) ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-md-2 text-right">
                <strong><?= __('Modified') ?>:</strong>
            </div>
            <div class="col-xs-8 col-md-4">
                <?= h($surveyAnswer->modified) ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-md-2 text-right">
                <strong><?= __('Answer') ?>:</strong>
            </div>
            <div class="col-xs-8 col-md-4">
                <?= $this->Text->autoParagraph(h($surveyAnswer->answer)); ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
        <div class="row">
            <div class="col-xs-4 col-md-2 text-right">
                <strong><?= __('Comment') ?>:</strong>
            </div>
            <div class="col-xs-8 col-md-4">
                <?= $this->Text->autoParagraph(h($surveyAnswer->comment)); ?>
            </div>
            <div class="clearfix visible-xs visible-sm"></div>
        </div>
    </div>
</section>

<?php

$surveyId = !empty($survey->slug) ? $survey->slug : $survey->id;

$options['title'] = __d('Qobo/Survey',
    '{0} &raquo; {1} &raquo; {2}',
    $this->Html->link(__d('Qobo/Survey', 'Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]),
    $section->get('name')
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
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
                    <?= h($section->get('name')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'ID') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($section->get('id')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Active') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $section->get('active') ? __d('Qobo/Survey', 'Yes') : __d('Qobo/Survey', 'No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Order') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($section->get('order')) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __d('Qobo/Survey', 'Default Section') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= $section->get('is_default') ? __d('Qobo/Survey', 'Yes') : __d('Qobo/Survey', 'No'); ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
        </div>
    </div>

    <div class="nav-tabs-custom">
        <ul id="relatedTabs" class="nav nav-tabs" role="tablist">
            <li role="presentation">
                <a href="#manage-survey-questions" aria-controls="manage-content" role="tab" data-toggle="tab">
                    <i class="fa fa-list-ul"></i> <i class="fa question-circle"></i> <?= __d('Qobo/Survey', 'Questions'); ?>
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane" id="manage-survey-questions">
                <?= $this->element('Qobo/Survey.SurveySections/view_questions', ['survey' => $survey, 'section' => $section]); ?>
            </div>
        </div>
    </div>


</section>

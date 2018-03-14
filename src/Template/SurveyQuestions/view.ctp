<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyQuestion
 */
$options['title'] = 'View Question';
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
                    <strong><?= __('Created') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->created) ?>
                </div>
                <div class="clearfix visible-xs visible-sm"></div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-2 text-right">
                    <strong><?= __('Modified') ?>:</strong>
                </div>
                <div class="col-xs-8 col-md-4">
                    <?= h($surveyQuestion->modified) ?>
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
        </div>
    </div>
</section>

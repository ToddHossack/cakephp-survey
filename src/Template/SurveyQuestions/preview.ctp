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
$option['title'] = __(
    '{0} &raquo; Preview Question',
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $survey->get('slug')])
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
                    <?php if (empty($survey->get('publish_date'))) : ?>
                        <?= $this->Html->link(
                            '<i class="fa fa-pencil"></i> ' . __('Edit'),
                            [
                                'controller' => 'SurveyQuestions',
                                'action' => 'edit',
                                $survey->get('slug'),
                                $surveyQuestion->get('id')
                            ],
                            [
                                'class' => 'btn btn-default',
                                'escape' => false
                            ]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= h($surveyQuestion->get('question')) ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?= $this->element('Qobo/Survey.Answers/' . $surveyQuestion->type, ['entity' => $surveyQuestion, 'collapsed' => true]);?>
        </div>
    </div>
    <?php if (!empty($savedResults)) : ?>
    <div class="box box->primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Post Data Preview');?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?php pr($savedResults); ?>
        </div>
    </div>
    <?php endif; ?>
</section>

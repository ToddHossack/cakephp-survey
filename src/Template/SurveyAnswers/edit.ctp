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
$options['title'] = $this->Html->link($survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyId]);
$options['title'] .= ' &raquo; ';
$options['title'] .= $this->Html->link($question->question, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $question->id]);
$options['title'] .= ' &raquo; ';
$options['title'] .= __('Edit "{0}"', [$surveyAnswer->answer]);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title']; ?></h4>
        </div>
    </div>
</section>
<section class="content">
<div class="surveyChoices form large-9 medium-8 columns content">
    <?= $this->Form->create($surveyAnswer) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Details');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->input('answer') ?>
                    <?= $this->Form->input('comment') ?>
                    <?= $this->Form->input('score') ?>
                    <?= $this->Form->input('order') ?>
                </div>
            </div>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
        </div>
    </div>
</div>
</section>

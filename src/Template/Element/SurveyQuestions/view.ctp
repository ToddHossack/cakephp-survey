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
$surveyId = !empty($survey->slug) ? $survey->slug : $survey->id;
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?php if (empty($survey->publish_date)) : ?>
                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> ' . __('Add Question'),
                    ['controller' => 'SurveyQuestions', 'action' => 'add', $surveyId],
                    ['class' => 'btn btn-default', 'escape' => false]
                )?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
    <thead>
        <tr>
            <th scope="col"><?= __('Question') ?></th>
            <th scope="col"><?= __('Type') ?></th>
            <th scope="col"><?= __('Active') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($survey->survey_questions as $surveyQuestion) : ?>
    <tr>
        <td><?= h($surveyQuestion->question) ?></td>
        <td><?= h($questionTypes[$surveyQuestion->type]) ?></td>
        <td><?= h($surveyQuestion->active) ?></td>
        <td class="actions btn-group btn-group-xs">
            <?= $this->Html->link('<i class="fa fa-file"></i>', ['controller' => 'SurveyQuestions', 'action' => 'preview', $surveyId, $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
            <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyId, $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
            <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'SurveyQuestions', 'action' => 'edit', $surveyId, $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'SurveyQuestions', 'action' => 'delete', $surveyId, $surveyQuestion->id], ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete # {0}?', $surveyQuestion->id)]) ?>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

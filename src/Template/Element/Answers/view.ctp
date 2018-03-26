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
?>
<table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
    <thead>
        <tr>
            <th scope="col"><?= __('Question') ?></th>
            <th scope="col"><?= __('Answer') ?></th>
            <th scope="col"><?= __('Comment') ?></th>
            <th scope="col"><?= __('Created') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($survey->survey_questions as $question) : ?>
        <?php foreach ($question->survey_answers as $surveyAnswer) : ?>
        <tr>
            <td><?= $this->Html->link($question->question, ['controller' => 'SurveyQuestions', 'action' => 'view', $question->id])?></td>
            <td><?= h($surveyAnswer->answer) ?></td>
            <td><?= h($surveyAnswer->comment) ?></td>
            <td><?= h($surveyAnswer->created->i18nFormat('yyyy-MM-DD HH:mm')) ?></td>
            <td class="actions btn-group btn-group-xs">
                <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'SurveyAnswers', 'action' => 'view', $surveyAnswer->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
                <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'SurveyAnswers', 'action' => 'edit', $surveyAnswer->id], ['escape' => false, 'class' => 'btn btn-default']) ?>
                <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'SurveyAnswers', 'action' => 'delete', $surveyAnswer->id], ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete # {0}?', $surveyAnswer->id)]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </tbody>
</table>


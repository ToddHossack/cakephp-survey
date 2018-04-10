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
$surveyId = empty($survey->survey->slug) ? $survey->survey->id : $survey->survey->slug;

?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?= $this->Html->link(
                    '<i class="fa fa-plus"></i> ' . __('Add Answer'),
                    ['controller' => 'SurveyAnswers', 'action' => 'add', $surveyId, $surveyQuestion->id],
                    ['class' => 'btn btn-default', 'escape' => false]
                )?>
            </div>
        </div>
    </div>
</div>
<table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
    <thead>
        <tr>
            <th scope="col"><?= __('Order') ?></th>
            <th scope="col"><?= __('Answer') ?></th>
            <th scope="col"><?= __('Score') ?></th>
            <th scope="col"><?= __('Created') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surveyQuestion->survey_answers as $surveyAnswer) : ?>
        <tr>
            <td><?= h($surveyAnswer->order) ?></td>
            <td>
                <?php
                if (!in_array($surveyQuestion->type, ['textarea', 'input'])) {
                    echo h($surveyAnswer->answer);
                } else {
                    echo __('Text input answer');
                }
                ?>
            </td>
            <td><?= h($surveyAnswer->score) ?></td>
            <td><?= h($surveyAnswer->created->i18nFormat('yyyy-MM-DD HH:mm')) ?></td>
            <td class="actions">
                <div class="btn-group btn-group-xs">
                <?= $this->Html->link(
                    '<i class="fa fa-eye"></i>',
                    ['controller' => 'SurveyAnswers', 'action' => 'view', $surveyId, $surveyQuestion->id, $surveyAnswer->id],
                    ['escape' => false, 'class' => 'btn btn-default']
                )?>
                <?= $this->Html->link(
                    '<i class="fa fa-pencil"></i>',
                    ['controller' => 'SurveyAnswers', 'action' => 'edit', $surveyId, $surveyQuestion->id, $surveyAnswer->id],
                    ['escape' => false, 'class' => 'btn btn-default']
                )?>
                <?= $this->Form->postLink(
                    '<i class="fa fa-trash"></i>',
                    ['controller' => 'SurveyAnswers', 'action' => 'delete', $surveyId, $surveyQuestion->id, $surveyAnswer->id],
                    ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete # {0}?', $surveyAnswer->id)]
                )?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


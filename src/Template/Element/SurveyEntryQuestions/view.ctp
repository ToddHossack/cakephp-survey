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
$isPublished = empty($survey->survey->publish_date) ? false : true;
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?php if (!$isPublished) : ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-plus"></i> ' . __d('Qobo/Survey', 'Add Answer'),
                        ['controller' => 'SurveyAnswers', 'action' => 'add', $surveyId, $surveyQuestion->id],
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
            <th scope="col"><?= __d('Qobo/Survey', 'Order') ?></th>
            <th scope="col"><?= __d('Qobo/Survey', 'Answer') ?></th>
            <th scope="col"><?= __d('Qobo/Survey', 'Score') ?></th>
            <th scope="col"><?= __d('Qobo/Survey', 'Created') ?></th>
            <th scope="col" class="actions"><?= __d('Qobo/Survey', 'Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($surveyQuestion->survey_answers as $surveyAnswer) : ?>
        <tr>
            <td><?= h($surveyAnswer->order);?></td>
            <td>
                <?php
                if (!in_array($surveyQuestion->type, ['textarea', 'input'])) {
                    echo h($surveyAnswer->answer);
                } else {
                    echo __d('Qobo/Survey', 'Text input answer');
                }
                ?>
            </td>
            <td><?= h($surveyAnswer->score) ?></td>
            <td><?= h($surveyAnswer->created->i18nFormat('yyyy-MM-dd HH:mm')) ?></td>
            <td class="actions">
                <div class="btn-group btn-group-xs">
                <?php if (!$isPublished) : ?>
                    <?= $this->Form->postLink('<i class="fa fa-arrow-up"></i>', ['controller' => 'SurveyAnswers', 'action' => 'move', $surveyAnswer->id, 'up'], ['escape' => false, 'class' => 'btn btn-default']);?>
                    <?= $this->Form->postLink('<i class="fa fa-arrow-down"></i>', ['controller' => 'SurveyAnswers', 'action' => 'move', $surveyAnswer->id, 'down'], ['escape' => false, 'class' => 'btn btn-default']);?>
                <?php endif; ?>
                <?= $this->Html->link(
                    '<i class="fa fa-eye"></i>',
                    ['controller' => 'SurveyAnswers', 'action' => 'view', $surveyId, $surveyQuestion->id, $surveyAnswer->id],
                    ['escape' => false, 'class' => 'btn btn-default']
                )?>
                <?php if (!$isPublished) : ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-pencil"></i>',
                        ['controller' => 'SurveyAnswers', 'action' => 'edit', $surveyId, $surveyQuestion->id, $surveyAnswer->id],
                        ['escape' => false, 'class' => 'btn btn-default']
                    )?>
                    <?= $this->Form->postLink(
                        '<i class="fa fa-trash"></i>',
                        ['controller' => 'SurveyAnswers', 'action' => 'delete', $surveyId, $surveyQuestion->id, $surveyAnswer->id],
                        ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __d('Qobo/Survey', 'Are you sure you want to delete # {0}?', $surveyAnswer->id)]
                    )?>
                <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


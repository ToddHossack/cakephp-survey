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
                        '<i class="fa fa-plus"></i> ' . __('Add Section'),
                        ['controller' => 'SurveySections', 'action' => 'add', $surveyId],
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
            <th scope="col"><?= __('Order') ?></th>
            <th scope="col"><?= __('Name') ?></th>
            <th scope="col"><?= __('Questions') ?></th>
            <th scope="col"><?= __('Active') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($survey->get('survey_sections') as $item) : ?>
            <?php $hasQuestions = count($item->get('survey_questions')) ? true : false; ?>
             <tr>
                <td><?= h($item->get('order')) ?></td>
                <td><?= h($item->get('name')) ?></td>
                <td><?= h(count($item->get('survey_questions'))) ?></td>
                <td><?= h($item->get('active') ? __('Yes') : __('No')) ?></td>
                <td class="actions">
                    <div class="btn-group btn-group-xs">
                    <?php if (empty($survey->get('pubish_date'))) : ?>
                        <?= $this->Form->postLink('<i class="fa fa-arrow-up"></i>', ['controller' => 'SurveySections', 'action' => 'move', $item->get('id'), 'up'], ['escape' => false, 'class' => 'btn btn-default']) ?>
                        <?= $this->Form->postLink('<i class="fa fa-arrow-down"></i>', ['controller' => 'SurveySections', 'action' => 'move', $item->get('id'), 'down'], ['escape' => false, 'class' => 'btn btn-default']) ?>

                        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'SurveySections', 'action' => 'edit', $surveyId, $item->get('id')], ['escape' => false, 'class' => 'btn btn-default']) ?>
                        <?php if (! $hasQuestions) : ?>
                            <?= $this->Form->postLink('<i class="fa fa-trash"></i>', ['controller' => 'SurveySections', 'action' => 'delete', $surveyId, $item->get('id')], ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete {0}?', $item->get('name'))]) ?>
                        <?php endif; ?>
                    <?php endif;?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

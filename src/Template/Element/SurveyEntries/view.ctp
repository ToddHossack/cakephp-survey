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
use Cake\Core\Configure;

$surveyId = !empty($survey->slug) ? $survey->slug : $survey->id;
$statuses = Configure::read('Survey.Options.statuses');
?>
<div class="row">
    <div class="col-xs-12 col-md-12">
        <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?php if (empty($survey->publish_date)) : ?>
                    <?= $this->Html->link(
                        '<i class="fa fa-plus"></i> ' . __('Add Submit'),
                        ['controller' => 'Surveys', 'action' => 'preview', $surveyId],
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
            <th scope="col"><?= __('Survey ID') ?></th>
            <th scope="col"><?= __('Resource') ?></th>
            <th scope="col"><?= __('Resource ID') ?></th>
            <th scope="col"><?= __('Status') ?></th>
            <th scope="col"><?= __('Grade') ?></th>
            <th scope="col"><?= __('Submit Date') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($entries as $item) : ?>
             <tr>
                <td><?= h($item->get('survey_id')) ?></td>
                <td><?= h($item->get('resource')) ?></td>
                <td><?= h($item->get('resource_id')) ?></td>
                <td><?= in_array($item->get('status'), array_keys($statuses)) ? $statuses[$item->get('status')] : $item->get('status') ?></td>
                <td><?= h($item->get('grade')) ?></td>
                <td><?= h($item->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm:ss')) ?></td>
                <td class="actions">
                    <div class="btn-group btn-group-xs">
                    <?php if (empty($survey->get('pubish_date'))) : ?>
                        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'SurveyEntries', 'action' => 'view', $surveyId, $item->get('id')], ['escape' => false, 'class' => 'btn btn-default']) ?>
                        <?= $this->Html->link('<i class="fa fa-pencil"></i>', ['controller' => 'SurveyEntries', 'action' => 'edit', $surveyId, $item->get('id')], ['escape' => false, 'class' => 'btn btn-default']) ?>
                    <?php endif;?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

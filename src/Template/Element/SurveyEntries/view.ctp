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
            <th scope="col"><?= __('Origin') ?> </th>
            <th scope="col"><?= __('Status') ?></th>
            <th scope="col"><?= __('Score') ?></th>
            <th scope="col"><?= __('Submit Date') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($entries as $item) : ?>
            <?php
                $resourceUser = $item->get('resource_user');

                if (!empty($resourceUser)) {
                    $resourceUrl = $this->Html->link($resourceUser['displayField'], $resourceUser['url']);
                }
            ?>
             <tr>
                <td><?= $resourceUrl ?></td>
                <td><?= in_array($item->get('status'), array_keys($statuses)) ? $statuses[$item->get('status')] : $item->get('status') ?></td>
                <td><?= h($item->get('score')) ?></td>
                <td><?= h($item->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm:ss')) ?></td>
                <td class="actions">
                    <div class="btn-group btn-group-xs">
                        <?= $this->Html->link('<i class="fa fa-eye"></i>', ['controller' => 'SurveyEntries', 'action' => 'view', $item->get('id')], ['escape' => false, 'class' => 'btn btn-default']) ?>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

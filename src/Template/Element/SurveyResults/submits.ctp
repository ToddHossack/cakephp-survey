<?php
$surveyId = !empty($survey->slug) ? $survey->slug : $survey->id;
?>
<table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
    <thead>
        <tr>
            <th scope="col"><?= __('User') ?></th>
            <th scope="col"><?= __('Submit Date') ?></th>
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($submits as $item) : ?>
    <tr>
        <td><?= !empty($item->user->get('name')) ? $item->user->get('name') : $item->user->username ?></td>
        <td><?= h($item->submit_date);?></td>
        <td class="actions">
            <div class="btn-group btn-group-xs">
                <?= $this->Html->link(
                    '<i class="fa fa-eye"></i>',
                    [
                        'plugin' => 'Qobo/Survey',
                        'controller' => 'Surveys',
                        'action' => 'viewSubmit',
                        $surveyId,
                        $item->submit_id
                    ],
                    [
                        'class' => 'btn btn-default',
                        'escape' => false,
                    ]
                )?>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>


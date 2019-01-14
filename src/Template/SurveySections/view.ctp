<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveySection
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Survey Section'), ['action' => 'edit', $surveySection->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Survey Section'), ['action' => 'delete', $surveySection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surveySection->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Survey Sections'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Section'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Surveys'), ['controller' => 'Surveys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey'), ['controller' => 'Surveys', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="surveySections view large-9 medium-8 columns content">
    <h3><?= h($surveySection->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($surveySection->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Survey') ?></th>
            <td><?= $surveySection->has('survey') ? $this->Html->link($surveySection->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveySection->survey->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($surveySection->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($surveySection->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($surveySection->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($surveySection->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $surveySection->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
</div>

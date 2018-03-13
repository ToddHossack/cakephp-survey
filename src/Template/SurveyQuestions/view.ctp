<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyQuestion
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Survey Question'), ['action' => 'edit', $surveyQuestion->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Survey Question'), ['action' => 'delete', $surveyQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surveyQuestion->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Survey Questions'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Question'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Surveys'), ['controller' => 'Surveys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey'), ['controller' => 'Surveys', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="surveyQuestions view large-9 medium-8 columns content">
    <h3><?= h($surveyQuestion->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($surveyQuestion->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Survey') ?></th>
            <td><?= $surveyQuestion->has('survey') ? $this->Html->link($surveyQuestion->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyQuestion->survey->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($surveyQuestion->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($surveyQuestion->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($surveyQuestion->trashed) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Active') ?></th>
            <td><?= $surveyQuestion->active ? __('Yes') : __('No'); ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Question') ?></h4>
        <?= $this->Text->autoParagraph(h($surveyQuestion->question)); ?>
    </div>
</div>

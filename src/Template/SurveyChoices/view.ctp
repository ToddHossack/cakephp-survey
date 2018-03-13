<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyChoice
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Survey Choice'), ['action' => 'edit', $surveyChoice->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Survey Choice'), ['action' => 'delete', $surveyChoice->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surveyChoice->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Survey Choices'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Choice'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Survey Questions'), ['controller' => 'SurveyQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Question'), ['controller' => 'SurveyQuestions', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="surveyChoices view large-9 medium-8 columns content">
    <h3><?= h($surveyChoice->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($surveyChoice->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Survey Question') ?></th>
            <td><?= $surveyChoice->has('survey_question') ? $this->Html->link($surveyChoice->survey_question->id, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyChoice->survey_question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($surveyChoice->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($surveyChoice->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($surveyChoice->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($surveyChoice->trashed) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Choice') ?></h4>
        <?= $this->Text->autoParagraph(h($surveyChoice->choice)); ?>
    </div>
    <div class="row">
        <h4><?= __('Comment') ?></h4>
        <?= $this->Text->autoParagraph(h($surveyChoice->comment)); ?>
    </div>
</div>

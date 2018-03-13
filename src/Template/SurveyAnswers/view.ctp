<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyAnswer
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Survey Answer'), ['action' => 'edit', $surveyAnswer->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Survey Answer'), ['action' => 'delete', $surveyAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surveyAnswer->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Survey Answers'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Answer'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Surveys'), ['controller' => 'Surveys', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey'), ['controller' => 'Surveys', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Survey Questions'), ['controller' => 'SurveyQuestions', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Question'), ['controller' => 'SurveyQuestions', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Survey Choices'), ['controller' => 'SurveyChoices', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Survey Choice'), ['controller' => 'SurveyChoices', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="surveyAnswers view large-9 medium-8 columns content">
    <h3><?= h($surveyAnswer->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= h($surveyAnswer->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Survey') ?></th>
            <td><?= $surveyAnswer->has('survey') ? $this->Html->link($surveyAnswer->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyAnswer->survey->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Survey Question') ?></th>
            <td><?= $surveyAnswer->has('survey_question') ? $this->Html->link($surveyAnswer->survey_question->id, ['controller' => 'SurveyQuestions', 'action' => 'view', $surveyAnswer->survey_question->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Survey Choice') ?></th>
            <td><?= $surveyAnswer->has('survey_choice') ? $this->Html->link($surveyAnswer->survey_choice->id, ['controller' => 'SurveyChoices', 'action' => 'view', $surveyAnswer->survey_choice->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('User') ?></th>
            <td><?= $surveyAnswer->has('user') ? $this->Html->link($surveyAnswer->user->id, ['controller' => 'Users', 'action' => 'view', $surveyAnswer->user->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($surveyAnswer->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($surveyAnswer->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Trashed') ?></th>
            <td><?= h($surveyAnswer->trashed) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Answer') ?></h4>
        <?= $this->Text->autoParagraph(h($surveyAnswer->answer)); ?>
    </div>
</div>

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

$resourceUser = $surveyEntry->get('resource_user');

$options['title'] = __(
    '{0} &raquo; {1} &raquo; {2}',
    $this->Html->link(__('Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]),
    __('Submit at "{0}" by "{1}"', $surveyEntry->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm'), $resourceUser['displayField'])
);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
                <?= $this->Form->postLink(
                    '<i class="fa fa-trash"></i> ' . __('Delete'),
                    ['plugin' => 'Qobo/Survey', 'controller' => 'SurveyEntries', 'action' => 'delete', $surveyEntry->get('id')],
                    ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __('Are you sure you want to delete # {0}', $survey->name)]
                ); ?>
            </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <?= $this->Form->create() ?>
    <?= $this->Form->hidden('SurveyEntries.id', ['value' => $surveyEntry->get('id')]) ?>
    <?php $key = 0; ?>
     <?php foreach ($survey->get('survey_sections') as $section) : ?>
         <?php foreach ($section->get('survey_questions') as $question) : ?>
                 <div class="box no-border">
                     <div class="box-header with-border">
                         <h3 class="box-title <?= $question->get('is_required') ? 'required' : '' ?>">
                             <?= $question->get('question');?>
                             <label></label>
                              <?= __('(Score: {0})', $this->Survey->getQuestionScore($question, $surveyEntry->get('id'))) ?>
                         </h3>
                     </div>
                     <div class="box-body">
                         <div class="row">
                             <div class="col-xs-12 col-md-6">
                                 <?= $this->element(
                                     'Qobo/Survey.Answers/' . $question->get('type'),
                                     [
                                         'entity' => $question,
                                         'key' => $key,
                                         'collapsed' => false,
                                         'loadResults' => true,
                                         'disabled' => true,
                                         'showAnswerScore' => true,
                                     ])?>
                             </div>
                         </div>
                     </div>
                     <div class="box-footer">
                         <?= $this->Form->hidden('SurveyResults.' . $key . '.survey_question_id', ['value' => $question->get('id')]) ?>
                         <?= $this->Form->radio(
                             'SurveyResults.' . $key . '.status',
                             [
                                 ['value' => 'pass', 'text' => __('Pass')],
                                 ['value' => 'fail', 'text' => __('Fail')]
                             ],
                             [
                                 'value' => $question->getSubmitStatus($surveyEntry->get('id'))
                             ]
                         ) ?>
                     </div>
                 </div>
         <?php $key++; ?>
         <?php endforeach; ?>
     <?php endforeach; ?>

     <div class="box box-info">
         <div class="box-header with-border">
             <h3 class="box-title"><?= __('Edit Entry Details') ?></h3>
         </div>
         <div class="box-body">
             <div class="row">
                 <div class="col-md-6 col-xs-12">
                     <h4><?= __('Total Score: {0}', $surveyEntry->getTotalScore()) ?></h4>
                 </div>
             </div>
             <div class="row">
                 <div class="col-md-4 col-xs-12">
                     <?= $this->Form->control(
                         'SurveyEntries.status',
                         [
                             'type' => 'select',
                             'options' => $entryStatuses,
                             'value' => $surveyEntry->get('status'),
                             'label' => __('Submit Status'),
                             'empty' => __('Choose status'),
                         ]
                     ) ?>
                 </div>
             </div>
         </div>
         <div class="box-footer">
             <?= $this->Form->button(__('Save')) ?>
         </div>
     </div>
     <?= $this->Form->end() ?>
</section>

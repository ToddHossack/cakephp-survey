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
                <?= $this->Html->link(
                        '<i class="fa fa-pencil"></i> ' . __('Edit'),
                        ['plugin' => 'Qobo/Survey', 'controller' => 'SurveyEntries', 'action' => 'edit', $surveyEntry->get('id')],
                        ['class' => 'btn btn-default', 'escape' => false]
                    ); ?>
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
    <?php $key = 0; ?>
     <?php foreach ($survey->get('survey_sections') as $section) : ?>
         <?php foreach ($section->get('survey_questions') as $question) : ?>
                 <div class="box box-info">
                     <div class="box-header with-border">
                         <h3 class="box-title <?= $question->get('is_required') ? 'required' : '' ?>">
                             <?= $question->get('question');?>
                             <label></label>
                         </h3>
                     </div>
                     <div class="box-body">
                         <?= $this->element('Qobo/Survey.Answers/' . $question->get('type'), ['entity' => $question, 'key' => $key, 'collapsed' => false, 'entry' => $surveyEntry]);?>
                     </div>
                     <div class="box-footer">
                         <div class="row">
                             <div class="col-md-6">
                                 <strong>Question Score: 1234</strong>
                             </div>
                             <div class="col-md-6">
                                 <div class="pull-right">
                                     <button class="btn btn-sm btn-warning"><i class="fa fa-exclamation-triangle"></i> <?= __('Review Grade') ?> </button>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
         <?php $key++; ?>
         <?php endforeach; ?>
     <?php endforeach; ?>
</section>

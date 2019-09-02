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
$surveyId = !empty($survey->get('slug')) ? $survey->get('slug') : $survey->get('id');

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
    <?= $this->Form->hidden('SurveyEntries.survey_id', ['value' => $survey->get('id')]) ?>
    <?php $count = 0; ?>
    <?php foreach ($survey->get('survey_sections') as $section) : ?>
        <?php foreach ($section->get('survey_questions') as $question) : ?>
                <?php
                    echo $this->element(
                        'Qobo/Survey.SurveyEntryQuestions/' . $question->get('type'),
                        [
                            'question' => $question,
                            'entryId' => $surveyEntry->get('id'),
                            'key' => $count,
                        ]
                    );
                ?>
            <?php $count++; ?>
        <?php endforeach;?>
    <?php endforeach;?>
    <?= $this->Form->button(__('Save'), ['class' => 'btn btn-success']) ?>
    <?= $this->Form->end() ?>
</section>

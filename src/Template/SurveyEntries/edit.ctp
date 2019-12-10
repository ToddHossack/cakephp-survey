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

$surveyId = !empty($survey->get('slug')) ? $survey->get('slug') : $survey->get('id');

$resourceUser = $surveyEntry->get('resource_user');

$options['title'] = __d('Qobo/Survey',
    '{0} &raquo; {1} &raquo; {2}',
    $this->Html->link(__d('Qobo/Survey', 'Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]),
    __d('Qobo/Survey', 'Submit at "{0}" by "{1}"', $surveyEntry->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm'), $resourceUser['displayField'])
);

$entryStatuses = Configure::read('Survey.Options.statuses');
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
                    '<i class="fa fa-trash"></i> ' . __d('Qobo/Survey', 'Delete'),
                    ['plugin' => 'Qobo/Survey', 'controller' => 'SurveyEntries', 'action' => 'delete', $surveyEntry->get('id')],
                    ['escape' => false, 'class' => 'btn btn-default', 'confirm' => __d('Qobo/Survey', 'Are you sure you want to delete # {0}', $survey->name)]
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

    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <h4><?= __d('Qobo/Survey', 'Current Score: {0}', $surveyEntry->get('score')) ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->control(
                        'SurveyEntries.status',
                        [
                            'options' => $entryStatuses,
                            'value' => $surveyEntry->get('status'),
                            'empty' => __d('Qobo/Survey', 'Choose Survey status')
                        ]
                    ) ?>
                </div>
            </div>
            <?= $this->Form->button(__d('Qobo/Survey', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>


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
                            'isDisabled' => false,
                        ]
                    );
                ?>
            <?php $count++; ?>
        <?php endforeach;?>
    <?php endforeach;?>
    <?= $this->Form->end() ?>
</section>

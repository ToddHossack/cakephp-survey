<?php
$surveyId = empty($survey->get('slug')) ? $survey->get('id') : $survey->get('slug');
$resourceUser = $surveyEntry->get('resource_user');

$options['title'] = __(
    '{0} &raquo; {1} &raquo; {2} &raquo; Review the Grade',
    $this->Html->link(__('Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId]),
    $this->Html->link(
        __('Submit at "{0}" by {1}', $surveyEntry->get('submit_date')->i18nFormat('yyyy-MM-dd HH:mm'), $resourceUser['displayField']),
        [
            'controller' => 'SurveyEntries',
            'action' => 'view',
            $surveyEntry->get('id')
        ]
    )
);

$status = [
    'passed' => __('Passed'),
    'failed' => __('Failed'),
];
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
        </div>
    </div>
</section>
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Question Result Preview')?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-12">
                    <?= $question->get('question') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <?= $this->element(
                        'Qobo/Survey.Answers/' . $question->get('type'),
                        [
                            'entity' => $question,
                            'key' => 0,
                            'collapsed' => false,
                            'loadResults' => true,
                            'disabled' => true,
                            'showAnswerScore' => true,
                        ])?>
                </div>
            </div>
        </div>
    </div>

    <?= $this->Form->create(); ?>
    <div class="box box-info">
        <div class="box-header with-border"><h3 class="box-title"><?= __('Question Submit Details')?></h3></div>
        <div class="box-body">
            <?php foreach ($question->get('survey_answers') as $answer) : ?>
                <?php foreach ($submits as $key => $entity) : ?>
                    <?php
                    if ($answer->get('id') !== $entity->get('survey_answer_id')) {
                        continue;
                    }
                    ?>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class=""><?= $answer->get('answer') ?></div>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?= $this->Form->hidden('SurveyResults.' . $key . '.id', ['value' => $entity->get('id')]) ?>
                            <?= $this->Form->control(
                                'SurveyResults.' . $key . '.status',
                                [
                                    'value' => $entity->get('status'),
                                    'type' => 'select',
                                    'options' => $status,
                                    'label' => __('Question Submit Status'),
                                    'empty' => __('Choose Status')
                                ]
                            ) ?>
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <?= $this->Form->control(
                                'SurveyResults.' . $key . '.comment',
                                [
                                    'value' => $entity->get('comment'),
                                    'type' => 'textarea',
                                    'label' => __('If failed, leave a comment why:'),
                                    'placeholder' => __('Short comment here')
                                ]
                            ) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach;?>
        </div>
        <div class="box-footer">
            <?= $this->Form->button(__('Save'), ['type' => 'submit']); ?>
            <?= $this->Form->end(); ?>
            <div class="pull-right">
            <?= $this->Form->postLink(
                __('Fail All'),
                [
                    'controller' => 'SurveyResults',
                    'action' => 'fail',
                    $surveyEntry->get('id'),
                    $question->get('id')
                ],
                [
                    'class' => 'btn btn-danger',
                    'confirm' => __('Are you sure that you want to fail all choices?')
                ]
            ) ?>
        </div>
        </div>
    </div>
</section>

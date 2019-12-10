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
$surveyId = empty($survey->get('slug')) ? $survey->get('id') : $survey->get('slug');

$options['title'] = (string)__d('Qobo/Survey',
    '{0} &raquo; Submission Details',
    $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId])
);

$order = 1;
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4>
                <?= $options['title']; ?>
            </h4>
        </div>
        <div class="col-xs-12 col-md-6">
        </div>
    </div>
</section>
<section class="content">
    <?php foreach ($surveyEntry->get('survey_entry_questions') as $k => $entryQuestion) : ?>
        <?php $surveyQuestion = $entryQuestion->get('survey_question'); ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= __d('Qobo/Survey', '{0}. {1}', $order, $surveyQuestion->get('question')) ?></h3>
            </div>
            <div class="box-body">
                <?php
                if (empty($entryQuestion->get('survey_results'))) {
                    continue;
                }

                $isOpenEndedQuestion = in_array($surveyQuestion->get('type'), ['input', 'textarea']) ? true : false;

                echo $isOpenEndedQuestion ? '' : '<ul>';

                foreach ($entryQuestion->get('survey_results') as $surveyResult) {
                    $answer = $surveyResult->get('survey_answer');

                    echo $isOpenEndedQuestion
                        ? __d('Qobo/Survey', '<p>{0}</p>', $surveyResult->get('result'))
                        : __d('Qobo/Survey', '<li>{0}</li>', $answer->get('answer'));
                }

                echo $isOpenEndedQuestion ? '' : '</ul>';
                ?>
            </div>
        </div>
    <?php $order++; ?>
    <?php endforeach; ?>
</section>

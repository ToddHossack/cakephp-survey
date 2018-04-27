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
$order = 1;

$surveyId = empty($survey->slug) ? $survey->id : $survey->slug;
$options['title'] = $this->Html->link(
    $survey->name,
    ['controller' => 'Surveys', 'action' => 'view', $surveyId]
);

$options['title'] .= ' &raquo; ';
$options['title'] .= __('Submission Details');
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
<?php foreach ($surveyResults as $question) : ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $order . '. ' . $question->question;?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?php
            $isText = in_array($question->type, ['input', 'textarea']) ? true : false;

            foreach ($question->survey_answers as $answer) {
                if (empty($answer->survey_results)) {
                    continue;
                }

                echo $isText ? '' : '<ul>';

                foreach ($answer->survey_results as $item) {
                    if ($answer->id !== $item->survey_answer_id) {
                        continue;
                    }

                    if ($isText) {
                        echo '<p>' . $item->result . '</p>';
                    } else {
                        echo '<li>' . $answer->answer . '</li>';
                    }
                }

                echo $isText ? '' :'</ul>';
            }
            ?>
        </div>
    </div>
    <?php $order++; ?>
<?php endforeach; ?>
</section>

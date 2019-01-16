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
$count = 1;
?>
<div class="row">
<?php foreach ($survey->get('survey_sections') as $section) : ?>
    <?php foreach ($section->get('survey_questions') as $k => $question) : ?>
            <div class="col-md-6 col-xs-12">
            <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?= $count . '. ' . $question->question;?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="row question-<?= $question->id ?> survey-question-results" data-id="<?= $question->id?>" data-survey-id="<?= $survey->id ?>">
                    <div class="col-xs-12 col-md-12">
                        <ul>
                        <?php if (!in_array($question->type, ['input', 'textarea'])) : ?>
                            <?php foreach ($question->survey_answers as $answer) : ?>
                                <li data-answer-id="<?= $answer->id?>"><?= $answer->answer; ?>. <strong>(Total: <span class="answer-stats"></span>)</strong></li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li>
                                Question is [<?= $question->type ?>] type.
                                <strong>(Total: <span class="answer-stats"></span>)</strong>
                            </li>
                        <?php endif; ?>
                        </ul>
                    </div>
                    <?php if (!in_array($question->type, ['input', 'textarea'])) : ?>
                    <div class="col-xs-12 col-md-12">
                        <div class="box-body">
                            <div class="col-xs-12 col-md-5 graphs-container" id="graph-<?= $question->id ?>" style="height:300px;width:400px;">
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
        </div>
        <?php $count++; ?>
    <?php endforeach; ?>
<?php endforeach;?>
</div>

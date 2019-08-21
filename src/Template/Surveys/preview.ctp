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
use Cake\Utility\Text;

$surveyId = empty($survey->get('slug')) ? $survey->get('id') : $survey->get('slug');

$options['title'] = __(
    '{0} &raquo; {1} &raquo; Preview',
     $this->Html->link(__('Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
     $this->Html->link($survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $surveyId])
);

$count = 1;
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
    </div>
</section>

<section class="content">
    <?php
        echo $this->Form->create($survey, ['action' => 'submit']);
        echo $this->Form->hidden('SurveyEntries.survey_id', ['value' => $survey->get('id')]);
        echo $this->Form->hidden('SurveyEntries.submit_date', ['value' => date('Y-m-d H:i:s', time())]);

        /** $user variable derives from AppController of application */
        echo $this->Form->hidden('SurveyEntries.resource_id', ['value' => $user['id']]);
        echo $this->Form->hidden('SurveyEntries.resource', ['value' => 'Users']);
    ?>

    <div class="nav-tabs-custom">

        <ul class="nav nav-tabs">
        <?php foreach ($survey->get('survey_sections') as $k => $section) : ?>
           <?php
               if (! count($section->get('survey_questions'))) {
                   continue;
               }
           ?>
           <li class="<?= $k == 0 ? 'active' : ''?>">
               <?= $this->Html->link(
                   $count . '. ' . $section->get('name'),
                   '#'. $section->get('id'),
                   [
                       'data-toggle' => 'tab',
                       'aria-expanded' => 'true'
                   ]
                ) ?>
           </li>
        <?php $count++; ?>
        <?php endforeach; ?>
        </ul>
        <?php $count = 0; ?>
        <?php $qcount = 1; ?>
        <div class="tab-content">
            <?php foreach ($survey->get('survey_sections') as $k => $section) :?>
            <?php
                if (! count($section->get('survey_questions'))) {
                    continue;
                }
            ?>
            <div class="tab-pane <?= $k == 0 ? 'active' : '' ?>" id="<?= $section->get('id') ?>">
                <?php foreach ($section->get('survey_questions') as $k => $question) : ?>
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title <?= $question->get('is_required') ? 'required' : '' ?>">
                                <?= $qcount ?>. <?= $question->get('question');?>
                                <label></label>
                            </h3>
                        </div>
                        <div class="box-body">
                            <?= $this->element('Qobo/Survey.Answers/' . $question->get('type'), ['entity' => $question, 'key' => $count, 'collapsed' => false]);?>
                        </div>
                    </div>
                <?php $qcount++; ?>
                <?php $count++; ?>
                <?php endforeach; ?>
            </div>

            <?php endforeach; ?>
        </div>
    </div>

    <?php if (Configure::read('Survey.Options.submitViaPreview')) : ?>
        <?= $this->Form->submit(__('Submit')); ?>
    <?php endif; ?>
    <?= $this->Form->end();?>
</section>

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

use Cake\Utility\Text;

$surveyId = empty($survey->slug) ? $survey->id : $survey->slug;

$options['title'] = $this->Html->link(__('Surveys'), [
    'controller' => 'Surveys',
    'action' => 'index'
]);
$options['title'] .= " &raquo; ";
$options['title'] .= $this->Html->link($survey->name, [
    'controller' => 'Surveys',
    'action' => 'view',
    $surveyId
]);
$options['title'] .= " &raquo; ";
$options['title'] .= __('Preview');
$count = 1;
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
            <div class="btn-group btn-group-sm" role="group">
            </div>
            </div>
        </div>
    </div>
</section>

<section class="content">
<?= $this->Form->create($survey); ?>
<?= $this->Form->hidden('submit_id', ['value' => Text::uuid()]) ?>
<?= $this->Form->hidden('submit_date', ['value' => date('Y-m-d H:i:s', time())]) ?>
<?php foreach ($survey->survey_questions as $k => $question) : ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $count ?>. <?= $question->question;?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?= $this->element('Qobo/Survey.Answers/' . $question->type, ['entity' => $question, 'key' => $k, 'collapsed' => false]);?>
        </div>
    </div>
    <?php $count++; ?>
<?php endforeach; ?>
</section>

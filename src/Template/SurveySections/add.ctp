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
$checked = $surveySection->active ? $surveySection->active : true;

echo $this->Html->css([
    'AdminLTE./plugins/iCheck/all',
    'Qobo/Survey.multi-select.dist'
], [
    'block' => 'css'
]);
echo $this->Html->script([
    'AdminLTE./plugins/iCheck/icheck.min',
    'Cms.icheck.init',
    'Qobo/Survey.jquery.multi-select',
    'Qobo/Survey.multiselect.init'
    ], ['block' => 'scriptBottom']);

$options['title'] = $this->Html->link(
    $survey->get('name'),
    [
        'controller' => 'Surveys',
        'action' => 'view',
        $survey->get('slug')
    ]);
$options['title'] .= ' &raquo; ';
$options['title'] .= __('Create {0}', ['Survey Section']);
?>

<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
    </div>
</section>
<section class="content">
    <?= $this->Form->create($surveySection) ?>
    <?= $this->Form->hidden('survey_id', ['value' => $survey->get('id')]) ?>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Details')?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->control('name') ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php
                    $label = $this->Form->label('active');
                    echo $this->Form->control('active', [
                        'type' => 'checkbox',
                        'checked' => $checked,
                        'class' => 'square',
                        'label' => false,
                        'templates' => [
                            'inputContainer' => '<div class="{{required}}">' . $label . '<div class="clearfix"></div>{{content}}</div>'
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->control('order') ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6">
                <?php if (!empty($questions)) : ?>
                <label>Add Questions to current Section:</label>
                <select multiple="multiple" class="my-select" name="section_questions[_ids][]">
                  <?php foreach ($questions as $item) : ?>
                      <option value="<?= $item->get('id')?>"><?= $item->get('question');?></option>
                  <?php endforeach; ?>
                </select>
                <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
    <?= $this->Form->button(__('Save')) ?>
    <?= $this->Form->end() ?>
</section>

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
echo $this->Html->css('AdminLTE./plugins/daterangepicker/daterangepicker');
echo $this->Html->script([
    'AdminLTE./plugins/daterangepicker/moment.min',
    'AdminLTE./plugins/daterangepicker/daterangepicker',
    'Qobo/Survey.init',
    ], [
        'block' => 'scriptBottom'
    ]);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __('Survey Publish date setting');?></h4>
        </div>
    </div>
</section>
<section class="content">
    <?= $this->Form->create($survey) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Date of publishing');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->input('Surveys.publish_date', [
                        'type' => 'text',
                        'class' => 'form-control',
                        'data-provide' => 'datetimepicker',
                        'required' => true,
                        'templates' => [
                            'input' => '<div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="{{type}}" name="{{name}}"{{attrs}}/>
                            </div>'
                        ]
                    ]) ?>
                </div>
            </div>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>


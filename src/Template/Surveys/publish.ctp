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
echo $this->Html->css('AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker');
echo $this->Html->script([
    'AdminLTE./bower_components/moment/min/moment.min',
    'AdminLTE./bower_components/bootstrap-daterangepicker/daterangepicker',
    'Qobo/Survey.init',
    ], [
        'block' => 'scriptBottom'
    ]);

$options['title'] = __d('Qobo/Survey',
    '{0} &raquo; {1} &raquo; Publishing survey',
    $this->Html->link(__d('Qobo/Survey', 'Surveys'), ['controller' => 'Surveys', 'action' => 'index']),
    $this->Html->link( $survey->get('name'), ['controller' => 'Surveys', 'action' => 'view', $survey->get('id')])
);

?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
    </div>
</section>
<section class="content">
    <?= $this->Form->create($survey) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __d('Qobo/Survey', 'Date of publishing');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->control('Surveys.publish_date', [
                        'type' => 'text',
                        'class' => 'form-control',
                        'data-provide' => 'datetimepicker',
                        'data-default-value' => date('Y-m-d H:i:00', time()),
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
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?= $this->Form->control('Surveys.expiry_date', [
                        'type' => 'text',
                        'class' => 'form-control',
                        'data-provide' => 'datetimepicker',
                        'data-default-value' => date('Y-m-d H:i:00', strtotime('+ 1 year', time())),
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
                </div>

            </div>
        <?= $this->Form->button(__d('Qobo/Survey', 'Submit')) ?>
        <?= $this->Html->link(
            __d('Qobo/Survey', 'Cancel'),
            [
                'plugin' => 'Qobo/Survey',
                'controller' => 'Surveys',
                'action' => 'view',
                $survey->get('id')
            ],
            [
                'class' => 'btn btn-link'
            ]) ?>
        <?= $this->Form->end() ?>
</section>

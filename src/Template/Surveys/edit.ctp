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
$checked = $survey->active ? $survey->active : true;

echo $this->Html->css('AdminLTE./plugins/iCheck/all', ['block' => 'css']);
echo $this->Html->script([
    'AdminLTE./plugins/iCheck/icheck.min',
    'Cms.icheck.init'
    ], ['block' => 'scriptBottom']);
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= __d('Qobo/Survey', 'Edit {0}', ['Survey']);?></h4>
        </div>
    </div>
</section>
<section class="content">
    <?= $this->Form->create($survey) ?>
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __d('Qobo/Survey', 'Details');?></h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->control('name'); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->control('category', ['options' => $categories]); ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <?php echo $this->Form->control('description');?>
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
            <?= $this->Form->button(__d('Qobo/Survey', 'Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>

<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $survey
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
                    <?php echo $this->Form->input('Surveys.publish_date', ['type' => 'text', 'data-provide' => 'datetimepicker']); ?>
                </div>
            </div>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</section>


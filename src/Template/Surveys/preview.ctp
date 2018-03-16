<?php
$options['title'] = __('Preview Survey: {0}', $survey->name);
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
            <?= $this->element('Qobo/Survey.Answers/' . $question->type, ['entity' => $question, 'key' => $k]);?>
        </div>
    </div>
    <?php $count++; ?>
<?php endforeach; ?>
    <div class="box">
        <?= $this->Form->submit(__('Submit'));?>
        <?= $this->Form->end(); ?>
    </div>
</section>


<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $surveyQuestion
 */
$options['title'] = 'Preview Question';
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <div class="btn-group btn-group-sm" role="group"></div>
            </div>
        </div>
    </div>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= h($surveyQuestion->question) ?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?= $this->element('Qobo/Survey.Answers/' . $surveyQuestion->type, ['entity' => $surveyQuestion]);?>
        </div>
    </div>
    <?php if (!empty($savedResults)) : ?>
    <div class="box box->primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= __('Post Data Preview');?></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body">
            <?php pr($savedResults); ?>
        </div>
    </div>
    <?php endif; ?>
</section>

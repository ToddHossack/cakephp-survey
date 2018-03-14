<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $surveyQuestions
 */
$options['title'] = 'Survey Questions';
?>
<section class="content-header">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <h4><?= $options['title'] ?></h4>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class="pull-right">
                <?= $this->element('CsvMigrations.Menu/index_top') ?>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
            <div class="table-responsive">
                <table class="table table-hover table-condensed table-vertical-align table-datatable" width="100%">
                    <thead>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('survey_id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('question') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($surveyQuestions as $surveyQuestion) : ?>
                    <tr>
                        <td><?= $surveyQuestion->has('survey') ? $this->Html->link($surveyQuestion->survey->name, ['controller' => 'Surveys', 'action' => 'view', $surveyQuestion->survey->id]) : '' ?></td>
                        <td><?= h($surveyQuestion->question) ?></td>
                        <td><?= h($questionTypes[$surveyQuestion->type]) ?></td>
                        <td><?= h($surveyQuestion->active) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('Preview'), ['action' => 'preview', $surveyQuestion->id]) ?>
                            <?= $this->Html->link(__('View'), ['action' => 'view', $surveyQuestion->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $surveyQuestion->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $surveyQuestion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surveyQuestion->id)]) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
            </div>
        </div>
        </div>
    </div>
</section>

<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $surveys
 */
$options['title'] = 'Surveys';
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
                            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('category') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('active') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('publish_date') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($surveys as $survey) : ?>
                        <tr>
                            <td><?= h($survey->name) ?></td>
                            <td><?= (!empty($categories[$survey->category])) ? $categories[$survey->category] : $survey->category ?></td>
                            <td><?= h($survey->active) ?></td>
                            <td><?= h($survey->created) ?></td>
                            <td><?= h($survey->publish_date) ?></td>
                            <td class="actions">
                                <?php if (!empty($survey->publish_date)) : ?>
                                <?= $this->Html->link(__('Publish'), ['action' => 'publish', $survey->id]);?>
                                <?= $this->Html->link(__('View'), ['action' => 'view', $survey->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $survey->id]) ?>
                                <?php endif; ?>
                                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $survey->id], ['confirm' => __('Are you sure you want to delete # {0}?', $survey->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
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
</section>

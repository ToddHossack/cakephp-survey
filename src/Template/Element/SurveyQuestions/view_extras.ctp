<?= $this->Html->script('Qobo/Survey.survey.general', ['block' => 'scriptBottom']);?>
<?php if (! empty($entity->extras)) : ?>
<div class="collapsable-extras">
    <a class="btn btn-xs <?= $collapsed ? 'collapsed' : '' ?>" href="#<?= $id ?>" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="<?= $id ?>">
        <i class="more-less fa <?= $collapsed ? 'fa-plus-square' : 'fa-minus-square'?>"></i>
    </a>
    <div class="<?= $collapsed ? 'collapse' : 'collapse in' ?>" id="<?= $id?>">
        <?= $entity->extras;?>
    </div>
</div>
<?php endif; ?>

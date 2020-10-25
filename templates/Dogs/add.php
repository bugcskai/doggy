<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dog $dog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Dogs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="dogs form content">
            <?= $this->Form->create($dog) ?>
            <fieldset>
                <legend><?= __('Add Dog') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('breed');
                    echo $this->Form->control('time_located');
                    echo $this->Form->control('picture');
                    echo $this->Form->control('place_id', ['options' => $places]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

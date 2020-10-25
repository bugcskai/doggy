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
            <?= $this->Html->link(__('Edit Dog'), ['action' => 'edit', $dog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Dog'), ['action' => 'delete', $dog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Dogs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Dog'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="dogs view content">
            <h3><?= h($dog->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($dog->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Breed') ?></th>
                    <td><?= h($dog->breed) ?></td>
                </tr>
                <tr>
                    <th><?= __('Picture') ?></th>
                    <td><?= h($dog->picture) ?></td>
                </tr>
                <tr>
                    <th><?= __('Place') ?></th>
                    <td><?= $dog->has('place') ? $this->Html->link($dog->place->name, ['controller' => 'Places', 'action' => 'view', $dog->place->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($dog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time Located') ?></th>
                    <td><?= h($dog->time_located) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($dog->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($dog->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

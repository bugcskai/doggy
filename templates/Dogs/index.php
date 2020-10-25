<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Dog[]|\Cake\Collection\CollectionInterface $dogs
 */
?>
<div class="dogs index content">
    <?= $this->Html->link(__('New Dog'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Dogs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('breed') ?></th>
                    <th><?= $this->Paginator->sort('time_located') ?></th>
                    <th><?= $this->Paginator->sort('picture') ?></th>
                    <th><?= $this->Paginator->sort('place_id') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dogs as $dog): ?>
                <tr>
                    <td><?= $this->Number->format($dog->id) ?></td>
                    <td><?= h($dog->name) ?></td>
                    <td><?= h($dog->breed) ?></td>
                    <td><?= h($dog->time_located) ?></td>
                    <td><?= h($dog->picture) ?></td>
                    <td><?= $dog->has('place') ? $this->Html->link($dog->place->name, ['controller' => 'Places', 'action' => 'view', $dog->place->id]) : '' ?></td>
                    <td><?= h($dog->created) ?></td>
                    <td><?= h($dog->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $dog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $dog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $dog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dog->id)]) ?>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

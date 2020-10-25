<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Place $place
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Place'), ['action' => 'edit', $place->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Place'), ['action' => 'delete', $place->id], ['confirm' => __('Are you sure you want to delete # {0}?', $place->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Places'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Place'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="places view content">
            <h3><?= h($place->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($place->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($place->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($place->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($place->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Location') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($place->location)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Dogs') ?></h4>
                <?php if (!empty($place->dogs)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Breed') ?></th>
                            <th><?= __('Time Located') ?></th>
                            <th><?= __('Picture') ?></th>
                            <th><?= __('Place Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($place->dogs as $dogs) : ?>
                        <tr>
                            <td><?= h($dogs->id) ?></td>
                            <td><?= h($dogs->name) ?></td>
                            <td><?= h($dogs->breed) ?></td>
                            <td><?= h($dogs->time_located) ?></td>
                            <td><?= h($dogs->picture) ?></td>
                            <td><?= h($dogs->place_id) ?></td>
                            <td><?= h($dogs->created) ?></td>
                            <td><?= h($dogs->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Dogs', 'action' => 'view', $dogs->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Dogs', 'action' => 'edit', $dogs->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Dogs', 'action' => 'delete', $dogs->id], ['confirm' => __('Are you sure you want to delete # {0}?', $dogs->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dog Entity
 *
 * @property int $id
 * @property string $name
 * @property string $breed
 * @property \Cake\I18n\FrozenTime $time_located
 * @property string $picture
 * @property int $place_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Place $place
 */
class Dog extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'breed' => true,
        'time_located' => true,
        'picture' => true,
        'place_id' => true,
        'created' => true,
        'modified' => true,
        'place' => true,
    ];
}

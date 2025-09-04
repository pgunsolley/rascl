<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ServicesTag Entity
 *
 * @property string $id
 * @property string $service_id
 * @property string $tag_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Service $service
 * @property \App\Model\Entity\Tag $tag
 */
class ServicesTag extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'service_id' => true,
        'tag_id' => true,
        'created' => true,
        'modified' => true,
        'service' => true,
        'tag' => true,
    ];
}

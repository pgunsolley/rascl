<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PoliciesTag Entity
 *
 * @property string $id
 * @property string $policy_id
 * @property string $tag_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Policy $policy
 * @property \App\Model\Entity\Tag $tag
 */
class PoliciesTag extends Entity
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
        'policy_id' => true,
        'tag_id' => true,
        'created' => true,
        'modified' => true,
        'policy' => true,
        'tag' => true,
    ];
}

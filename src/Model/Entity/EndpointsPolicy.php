<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EndpointsPolicy Entity
 *
 * @property string $id
 * @property string $endpoint_id
 * @property string $policy_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Endpoint $endpoint
 * @property \App\Model\Entity\Policy $policy
 */
class EndpointsPolicy extends Entity
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
        'endpoint_id' => true,
        'policy_id' => true,
        'created' => true,
        'modified' => true,
        'endpoint' => true,
        'policy' => true,
    ];
}

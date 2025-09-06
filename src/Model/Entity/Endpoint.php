<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Endpoint Entity
 *
 * @property string $id
 * @property string $service_id
 * @property string|null $description
 * @property string $url
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Service $service
 * @property \App\Model\Entity\Policy[] $policies
 * @property \App\Model\Entity\Tag[] $tags
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Method[] $methods
 */
class Endpoint extends Entity
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
        'description' => true,
        'url' => true,
        'created' => true,
        'modified' => true,
        'service' => true,
        'policies' => true,
        'tags' => true,
        'users' => true,
        'methods' => true,
    ];
}

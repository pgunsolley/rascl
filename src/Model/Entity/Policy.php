<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Policy Entity
 *
 * @property string $id
 * @property string $name
 * @property string|array $descriptor
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Endpoint[] $endpoints
 * @property \App\Model\Entity\Tag[] $tags
 */
class Policy extends Entity
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
        'name' => true,
        'descriptor' => true,
        'created' => true,
        'modified' => true,
        'endpoints' => true,
        'tags' => true,
    ];

    protected function _setDescriptor(string|array $value): string|array
    {
        if (is_array($value)) {
            return $value;
        }
        return json_encode(json_decode($value, true));
    }
}

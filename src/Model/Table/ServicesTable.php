<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Services Model
 *
 * @property \App\Model\Table\EndpointsTable&\Cake\ORM\Association\HasMany $Endpoints
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 *
 * @method \App\Model\Entity\Service newEmptyEntity()
 * @method \App\Model\Entity\Service newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Service> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Service get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Service findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Service patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Service> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Service|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Service saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Service>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Service>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Service>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Service> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Service>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Service>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Service>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Service> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ServicesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('services');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Endpoints', [
            'foreignKey' => 'service_id',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'service_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'services_tags',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        return $validator;
    }
}

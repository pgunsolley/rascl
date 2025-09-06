<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Methods Model
 *
 * @property \App\Model\Table\EndpointsTable&\Cake\ORM\Association\BelongsToMany $Endpoints
 *
 * @method \App\Model\Entity\Method newEmptyEntity()
 * @method \App\Model\Entity\Method newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Method> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Method get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Method findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Method patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Method> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Method|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Method saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Method>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Method>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Method>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Method> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Method>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Method>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Method>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Method> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MethodsTable extends Table
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

        $this->setTable('methods');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Endpoints');
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

        return $validator;
    }
}

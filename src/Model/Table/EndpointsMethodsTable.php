<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EndpointsMethods Model
 *
 * @property \App\Model\Table\EndpointsTable&\Cake\ORM\Association\BelongsTo $Endpoints
 * @property \App\Model\Table\MethodsTable&\Cake\ORM\Association\BelongsTo $Methods
 *
 * @method \App\Model\Entity\EndpointsMethod newEmptyEntity()
 * @method \App\Model\Entity\EndpointsMethod newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsMethod> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsMethod get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EndpointsMethod findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EndpointsMethod patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsMethod> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsMethod|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EndpointsMethod saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsMethod>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsMethod> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsMethod>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsMethod>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsMethod> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EndpointsMethodsTable extends Table
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

        $this->setTable('endpoints_methods');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Endpoints', [
            'foreignKey' => 'endpoint_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Methods', [
            'foreignKey' => 'method_id',
            'joinType' => 'INNER',
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
            ->uuid('endpoint_id')
            ->notEmptyString('endpoint_id');

        $validator
            ->integer('method_id')
            ->notEmptyString('method_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['endpoint_id'], 'Endpoints'), ['errorField' => 'endpoint_id']);
        $rules->add($rules->existsIn(['method_id'], 'Methods'), ['errorField' => 'method_id']);

        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EndpointsPolicies Model
 *
 * @property \App\Model\Table\EndpointsTable&\Cake\ORM\Association\BelongsTo $Endpoints
 * @property \App\Model\Table\PoliciesTable&\Cake\ORM\Association\BelongsTo $Policies
 *
 * @method \App\Model\Entity\EndpointsPolicy newEmptyEntity()
 * @method \App\Model\Entity\EndpointsPolicy newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsPolicy> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsPolicy get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EndpointsPolicy findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EndpointsPolicy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsPolicy> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsPolicy|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EndpointsPolicy saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsPolicy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsPolicy>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsPolicy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsPolicy> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsPolicy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsPolicy>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsPolicy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsPolicy> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EndpointsPoliciesTable extends Table
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

        $this->setTable('endpoints_policies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Endpoints', [
            'foreignKey' => 'endpoint_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Policies', [
            'foreignKey' => 'policy_id',
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
            ->uuid('policy_id')
            ->notEmptyString('policy_id');

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
        $rules->add($rules->existsIn(['policy_id'], 'Policies'), ['errorField' => 'policy_id']);

        return $rules;
    }
}

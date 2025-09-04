<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EndpointsUsers Model
 *
 * @property \App\Model\Table\EndpointsTable&\Cake\ORM\Association\BelongsTo $Endpoints
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\EndpointsUser newEmptyEntity()
 * @method \App\Model\Entity\EndpointsUser newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsUser> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EndpointsUser findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EndpointsUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EndpointsUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsUser>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsUser>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsUser> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EndpointsUsersTable extends Table
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

        $this->setTable('endpoints_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Endpoints', [
            'foreignKey' => 'endpoint_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->uuid('user_id')
            ->notEmptyString('user_id');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}

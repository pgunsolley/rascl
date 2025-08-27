<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PoliciesUsers Model
 *
 * @property \App\Model\Table\PoliciesTable&\Cake\ORM\Association\BelongsTo $Policies
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\PoliciesUser newEmptyEntity()
 * @method \App\Model\Entity\PoliciesUser newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PoliciesUser> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PoliciesUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PoliciesUser findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PoliciesUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PoliciesUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PoliciesUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PoliciesUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesUser>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesUser>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesUser> deleteManyOrFail(iterable $entities, array $options = [])
 */
class PoliciesUsersTable extends Table
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

        $this->setTable('policies_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Policies', [
            'foreignKey' => 'policy_id',
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
            ->uuid('policy_id')
            ->notEmptyString('policy_id');

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
        $rules->add($rules->existsIn(['policy_id'], 'Policies'), ['errorField' => 'policy_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}

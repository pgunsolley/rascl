<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Policies Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Policy newEmptyEntity()
 * @method \App\Model\Entity\Policy newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Policy> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Policy get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Policy findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Policy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Policy> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Policy|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Policy saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Policy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Policy>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Policy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Policy> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Policy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Policy>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Policy>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Policy> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PoliciesTable extends Table
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

        $this->setTable('policies');
        $this->setDisplayField('url');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->uuid('user_id')
            ->notEmptyString('user_id');

        $validator
            ->url('url')
            ->maxLength('url', 255)
            ->requirePresence('url', 'create')
            ->notEmptyString('url');

        $validator
            ->scalar('descriptor')
            ->maxLength('descriptor', 4294967295)
            ->requirePresence('descriptor', 'create')
            ->notEmptyString('descriptor')
            ->add('descriptor', 'validJson', [
                'rule' => fn($value) => json_validate($value),
                'message' => 'The descriptor must be syntactically valid JSON',
            ]);

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
        $rules->add($rules->isUnique(['user_id', 'url']), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function findIndex(SelectQuery $query)
    {
        return $query->select(['id', 'user_id', 'url', 'created', 'modified']);
    }
}

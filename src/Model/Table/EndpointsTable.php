<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Endpoints Model
 *
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\BelongsTo $Services
 * @property \App\Model\Table\PoliciesTable&\Cake\ORM\Association\BelongsToMany $Policies
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsToMany $Tags
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Endpoint newEmptyEntity()
 * @method \App\Model\Entity\Endpoint newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Endpoint> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Endpoint get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Endpoint findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Endpoint patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Endpoint> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Endpoint|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Endpoint saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Endpoint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Endpoint>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Endpoint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Endpoint> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Endpoint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Endpoint>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Endpoint>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Endpoint> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EndpointsTable extends Table
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

        $this->setTable('endpoints');
        $this->setDisplayField('url');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Services', [
            'foreignKey' => 'service_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsToMany('Policies', [
            'foreignKey' => 'endpoint_id',
            'targetForeignKey' => 'policy_id',
            'joinTable' => 'endpoints_policies',
        ]);
        $this->belongsToMany('Tags', [
            'foreignKey' => 'endpoint_id',
            'targetForeignKey' => 'tag_id',
            'joinTable' => 'endpoints_tags',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'endpoint_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'endpoints_users',
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
            ->uuid('service_id')
            ->notEmptyString('service_id');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['service_id'], 'Services'), ['errorField' => 'service_id']);

        return $rules;
    }
}

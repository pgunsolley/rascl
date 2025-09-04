<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PoliciesTags Model
 *
 * @property \App\Model\Table\PoliciesTable&\Cake\ORM\Association\BelongsTo $Policies
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\PoliciesTag newEmptyEntity()
 * @method \App\Model\Entity\PoliciesTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\PoliciesTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PoliciesTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\PoliciesTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\PoliciesTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\PoliciesTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PoliciesTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\PoliciesTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\PoliciesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\PoliciesTag> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PoliciesTagsTable extends Table
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

        $this->setTable('policies_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Policies', [
            'foreignKey' => 'policy_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
            ->uuid('tag_id')
            ->notEmptyString('tag_id');

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
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}

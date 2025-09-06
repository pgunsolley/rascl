<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ServicesTags Model
 *
 * @property \App\Model\Table\ServicesTable&\Cake\ORM\Association\BelongsTo $Services
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\ServicesTag newEmptyEntity()
 * @method \App\Model\Entity\ServicesTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ServicesTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ServicesTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ServicesTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ServicesTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ServicesTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ServicesTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ServicesTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ServicesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ServicesTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ServicesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ServicesTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ServicesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ServicesTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ServicesTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ServicesTag> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ServicesTagsTable extends Table
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

        $this->setTable('services_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Services');
        $this->belongsTo('Tags');
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
        $rules->add($rules->existsIn(['service_id'], 'Services'), ['errorField' => 'service_id']);
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}

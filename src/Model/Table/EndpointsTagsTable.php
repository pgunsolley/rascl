<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EndpointsTags Model
 *
 * @property \App\Model\Table\EndpointsTable&\Cake\ORM\Association\BelongsTo $Endpoints
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 *
 * @method \App\Model\Entity\EndpointsTag newEmptyEntity()
 * @method \App\Model\Entity\EndpointsTag newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsTag> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsTag get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\EndpointsTag findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\EndpointsTag patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\EndpointsTag> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\EndpointsTag|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\EndpointsTag saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsTag>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsTag> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsTag>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\EndpointsTag>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\EndpointsTag> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EndpointsTagsTable extends Table
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

        $this->setTable('endpoints_tags');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Endpoints');
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
            ->uuid('endpoint_id')
            ->notEmptyString('endpoint_id');

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
        $rules->add($rules->existsIn(['endpoint_id'], 'Endpoints'), ['errorField' => 'endpoint_id']);
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);

        return $rules;
    }
}

<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TagsUsers Model
 *
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\TagsUser newEmptyEntity()
 * @method \App\Model\Entity\TagsUser newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TagsUser> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TagsUser get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TagsUser findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TagsUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TagsUser> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TagsUser|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TagsUser saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TagsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsUser>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TagsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsUser> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TagsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsUser>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TagsUser>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsUser> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TagsUsersTable extends Table
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

        $this->setTable('tags_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
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
            ->uuid('tag_id')
            ->notEmptyString('tag_id');

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
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => 'tag_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}

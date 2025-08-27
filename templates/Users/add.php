<div>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Please enter your email and choose a secure password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Register')) ?>
    <?= $this->Form->end() ?>
    Have an account? <?= $this->Html->link('Log In', ['_name' => 'login']) ?>
</div>

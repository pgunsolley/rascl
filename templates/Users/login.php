<div>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>
        <?= $this->Form->control('email') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Login')) ?>
    <?= $this->Form->end() ?>
    Don't have an account? <?= $this->Html->link('Register', ['_name' => 'register']) ?>
</div>

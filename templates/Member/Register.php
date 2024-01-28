<h1>Register</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('fullname') ?>
<?= $this->Form->control('username') ?>
<?= $this->Form->control('phone_no') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->button('Register') ?>
<?= $this->Form->end() ?>
<p>have an account? <a href="login">Login here</a>.</p>
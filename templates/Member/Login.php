<h1>Login</h1>
<?= $this->Form->create() ?>
<?= $this->Form->control('username') ?>
<?= $this->Form->control('password') ?>
<?= $this->Form->button('Login') ?>
<?= $this->Form->end() ?>
<p>Don't have an account? <a href="register">Register here</a>.</p>
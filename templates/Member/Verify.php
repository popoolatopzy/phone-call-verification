<h3>Verify your account</h3>
<?= h($message) ?>
<?= $this->Form->create() ?>
<?= $this->Form->control('otp',['placeholder' => 'Enter your verification code']) ?>
<?= $this->Form->button('Verify my account') ?>
<?= $this->Form->end() ?>
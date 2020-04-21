<?= print_r($request) ?>

<a href="<?= base_url("login") ?>">Login</a>
<a href="<?= base_url("register") ?>">Register</a>
<a href="<?= base_url("auth/destroy") ?>">Destroy Session</a>

<?= validation_errors() ?>
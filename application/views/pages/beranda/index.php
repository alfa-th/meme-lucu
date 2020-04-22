Hanya bisa diakses apabila login terjadi

<?= print_r($this->session->userdata()) ?>

<a href="<?= base_url("login") ?>">Login</a>
<a href="<?= base_url("register") ?>">Register</a>
<a href="<?= base_url("auth/logout") ?>">Destroy Session</a>

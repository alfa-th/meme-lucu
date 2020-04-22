<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Load semua stylesheets -->
  <?php $this->load->view("components/stylesheets") ?>

  <!-- Load semua script library -->
  <?php $this->load->view("components/scripts") ?>
</head>

<body>
  <div class="limiter" id="app">
    <div class="container-login100" style="background-image: url('images/uw.jpg');">
      <div class="wrap-login100">
        <?= form_open("auth/login", ["class" => "login100-form validate-form"]) ?>
        <!-- <span class="login100-form-logo">
          <i class="zmdi zmdi-landscape"></i>
        </span> -->

        <span class="login100-form-title p-b-34 p-t-27">
          Login
        </span>

        <div v-if="errors != null">
          <div v-for="(item, index) in errors">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              {{ item }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>

        <div v-if="success != null">
          <div v-for="(item, index) in success">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ item }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Masukkan username">
          <input class="input100" type="text" name="username" placeholder="Username">
          <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Masukkan password">
          <input class="input100" type="password" name="password" placeholder="Password">
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
        </div>

        <div class="contact100-form-checkbox">
          <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
          <label class="label-checkbox100" for="ckb1">
            Ingat Saya
          </label>
        </div>

        <div class="container-login100-form-btn">
          <button class="login100-form-btn">
            Login
          </button>
        </div>

        <div class="text-center p-t-90">
          <a class="txt1" href="#">
            Lupa Password?
          </a>
        </div>
        <div class="text-center p-t-10">
          <a class="txt1" href="<?= base_url("register") ?>">
            Registasi?
          </a>
        </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Custom Script -->
  <script>
    var app = new Vue({
      el: "#app",
      data: {
        errors: <?= json_encode($this->session->flashdata("error")) ?>,
        success: <?= json_encode($this->session->flashdata("success")) ?>
      }
    })
  </script>
</body>

</html>
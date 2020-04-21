<!DOCTYPE html>
<html lang="en">

<head>
  <title>Registrasi</title>
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
        <?= form_open("auth/register", ["class" => "login100-form validate-form"]) ?>
        <!-- <span class="login100-form-logo">
						<i class="zmdi zmdi-landscape"></i>
					</span> -->

        <span class="login100-form-title p-b-50 p-t-20">
          Registrasi
        </span>

        <div v-if="validation_errors != 'null'">
          <div v-for="(item, index) in validation_errors">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              {{ item }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter email">
          <input class="input100" type="text" name="email" placeholder="Email" />
          <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter username">
          <input class="input100" type="text" name="username" placeholder="Username" />
          <span class="focus-input100" data-placeholder="&#xf207;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter password">
          <input class="input100" type="password" name="password" placeholder="Password" />
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
        </div>

        <div class="wrap-input100 validate-input" data-validate="Enter confirm password">
          <input class="input100" type="confirm password" name="confirm_password" placeholder="Confirm Password" />
          <span class="focus-input100" data-placeholder="&#xf191;"></span>
        </div>

        <div class="contact100-form-checkbox">
          <input class="input-checkbox100" id="ckb1" type="checkbox" name="setuju" />
          <label class="label-checkbox100" for="ckb1">
            Saya setuju dengan syarat dan ketentuan
          </label>
        </div>

        <div class="container-login100-form-btn">
          <button class="login100-form-btn">
            Registrasi
          </button>
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
        validation_errors: <?= json_encode($this->session->flashdata("validation_errors")) ?>,
      }
    })
  </script>
</body>

</html>
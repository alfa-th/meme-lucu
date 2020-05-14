<header id="nav_app">
  <nav class="navbar navbar-expand-lg navbar-light text-light flex-column flex-md-row bd-navbar px-5" style="background-color: purple;">
    <a class="navbar-brand text-light" href="<?= base_url("") ?>">
      <img src="images/logo3.png" width="60px" height="60px" alt="meme-lucu">
    </a>
    <div class="collapse navbar-collapse d-block" id="navbarSupportedContent">
      <ul class="navbar-nav mr-1">
        <li class="nav-item">
          <a class="nav-link text-light" href="#">Meme Markotop</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-light" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?= empty($category_name) ? "Kategori Meme" : "Kategori " . ucfirst($category_name) ?>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="#" v-for="type in categories_type" v-bind:index="type" style="text-transform: capitalize">
              {{ type.nama }}
            </a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto pr-4 d-block d-md-flex">
        <?php if ($this->session->userdata("logged_in") == FALSE) : ?>
          <li class="nav-item">
            <a class="nav-link text-light" href="<?= base_url("register") ?>">Registrasi</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="<?= base_url("login") ?>">Masuk</a>
          </li>
        <?php else : ?>
          <li class=" nav-item">
            <a class="nav-link text-light" href="<?= base_url("upload") ?>">Upload Meme</a>
          </li>
          <li class=" nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?= $this->session->userdata("username") ?>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Opsi</a>
              <a class="dropdown-item" href="<?= base_url("auth/logout") ?>">Logout</a>
            </div>
          </li>
          <li>
            <a class="nav-link dropdown-toggle text-light" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Session Data
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <?php foreach ($this->session->userdata() as $key => $value) : ?>
                <a class="dropdown-item" href="#"><?= $key . " => " . $value ?></a>
              <?php endforeach; ?>
            </div>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
</header>

<script>
  var nav_app = new Vue({
    el: "#nav_app",
    data: {
      base_url: "<?= base_url("") ?>",
      categories_type: []
    },
    mounted: function() {
      axios
        .get(`${this.base_url}/api/v1/get_all_categories/`)
        .then(response => {
          this.categories_type = response.data.categories_type
        })
        .catch(error => {
          console.log("Error " + error)
        })
    }
  })
</script>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>MEME-LUCU</title>
  
  <!-- Load meta -->
  <?php $this->load->view("components/meta") ?>

  <!-- Load semua stylesheets -->
  <?php $this->load->view("components/stylesheets") ?>

  <!-- Load semua script library -->
  <?php $this->load->view("components/scripts") ?>
</head>

<!-- Load navbar -->
<?php $this->load->view("components/navbar") ?>

<body>
  <div id="app" class="container">
    <div class="row justify-content-center pt-5">
      <div>
        <div class="text-center justify-content-md-center">
          <h4 class="h4 text-gray-900 mb-3" style="color: black;">Upload Meme</h4>
          <img id="image" v-if="url" :src="url" style="width:1024px; height:768px; object-fit: contain;"/>
        </div>
        <div class="card o-hidden border-0 shadow-lg my-5" style="margin-top: 100px;">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg">
                <div class="container-fluid">
                  <?= form_open_multipart("upload/upload_action") ?>

                  <div class="mb-4" v-if="errors != null || success != null">
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
                  </div>

                  <div class="form-group">
                    <label class="my-2" for="berkas">Masukkan Gambar</label>
                    <input type="file" id="berkas" name="image-file" class="form-control" @change="onFileChange">
                  </div>

                  <div class="form-group">
                    <label class="my-2" for="berkas">Masukkan Judul</label>
                    <input type="text" name="judul" class="form-control" id="judul" placeholder="Judul">
                  </div>

                  <div id="form-group">
                    <label class="my-2" for="berkas">Kategori</label>
                    <select name="kategori" class="form-control">
                      <option value="none"></option>
                      <option value="strip">Strip</option>
                      <option value="dank">Dank</option>
                      <option value="pedas">Pedas</option>
                    </select>
                  </div>

                  <div class="form-group pt-3">
                    <button type="submit" class="btn btn-primary pt-2">Upload</button>
                  </div>

                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

<!-- Custom Script -->
<script>
  var app = new Vue({
    el: "#app",
    data: {
      errors: <?= json_encode($this->session->flashdata("error")) ?>,
      success: <?= json_encode($this->session->flashdata("success")) ?>,
      url: null
    },
    methods: {
      onFileChange(e) {
        const file = e.target.files[0];
        this.url = URL.createObjectURL(file);
      }
    }
  });
</script>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>MEME-LUCU</title>
  <meta charset="utf-8">
  <!-- Load semua stylesheets -->
  <?php $this->load->view("components/stylesheets") ?>

  <!-- Load semua script library -->
  <?php $this->load->view("components/scripts") ?>
</head>

<!-- Load navbar -->
<?php $this->load->view("components/navbar") ?>

<body>
  <div id="app" class="pt-5 mt-2">
    <div class="pb-5 pt" style="position: relative; z-index: 8;">
      <div class="container">
        <div class="row" style="margin-top: -50px;">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 my-5" v-for="post in posts">
            <img v-bind:src="post.img_link" alt="Image" class="img-fluid mb-3">
            <h3 class="text-primary h4 mb-2">{{ post.judul }}</h3>
            <a href="#" class="btn btn-primary btn-md">Upvote</a>
            <a href="#" class="btn btn-primary btn-md">Downvote</a>
            <a href="#" class="btn btn-primary btn-md">Lapor</a>
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
      posts: <?= json_encode($all_posts) ?>
    }
  });
</script>

</html>
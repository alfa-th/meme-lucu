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

    <div class="pb-5 pt" style="position: relative; z-index: 8;">
      <div class="container">
        <div class="row" style="margin-top: -50px;">
          <div class="col-md-6 col-lg-4 mb-4 mb-lg-0 my-5" v-for="(post, index) in posts" v-bind:key="post.id">
            <img v-bind:src="post.img_link" alt="Image" class="img-fluid mb-3">
            <h3 class="text-primary h4 mb-2">{{ post.judul }}</h3>

            <button v-on:click="upvote(post)" class="btn" v-bind:class="posts[index].state == 'Y' ? activeClass : passiveClass">Upvote</button>
            <button v-on:click="downvote(post)" class="btn" v-bind:class="posts[index].state == 'N' ? activeClass : passiveClass ">Downvote</button>
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
      base_url: "<?= base_url("") ?>",
      errors: <?= json_encode($this->session->flashdata("error")) ?>,
      success: <?= json_encode($this->session->flashdata("success")) ?>,
      posts: <?= json_encode($all_posts) ?>,
      username: "<?= $this->session->userdata("username") ?>",
      activeClass: "btn-primary",
      passiveClass: "btn-outline-primary"
    },
    mounted: function() {
      for (let i = 0; i < this.posts.length; i++) {
        axios
          .get(`${this.base_url}/api/v1/getState/${this.username}/${this.posts[i].id}`)
          .then(response => {
            Vue.set(this.posts[i], "state", response.data.state);
          })
          .catch(error => {
            return "Error getting state";
          })
      }
    },
    methods: {
      upvote: function(post) {
        if (post.state == "Y") {
          this.neutral(post)
        } else {
          axios
            .post(`${this.base_url}/post/action/upvote/${post.id}`)
            .then(response => {
              console.log("Upvoted " + post.id + ", Old State: " + post.state);
              post.state = "Y";
            })
            .catch(error => {
              console.log("Error upvote ", error);
            })
        }
      },
      downvote: function(post) {
        if (post.state == "N") {
          this.neutral(post)
        } else {
          axios
            .post(`${this.base_url}/post/action/downvote/${post.id}`)
            .then(response => {
              console.log("Downvoted " + post.id + ", Old State: " + post.state);
              post.state = "N";
            })
            .catch(error => {
              console.log("Error downvote ", error);
            })
        }
      },
      neutral: function(post) {
        axios
          .post(`${this.base_url}/post/action/neutral/${post.id}`)
          .then(response => {
            console.log("Neutralized " + post.id + ", Old State: " + post.state);
            post.state = "-";
          })
          .catch(error => {
            console.log("Error netral", error);
          })
      }
    },
  });
</script>

</html>
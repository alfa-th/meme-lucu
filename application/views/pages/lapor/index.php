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
        <div class="card-columns">
          <div class="card" v-for="(post, index) in posts" v-bind:key="index">
            <a v-bind:href="base_url + 'post/' + post.id">
              <img v-bind:src="base_url + post.img_link" alt="Image" class="card-img-top img-fluid mb-3">
            </a>
            <div class="card-body">
              <h3 class="card-title">{{ post.judul }}</h3>
              <span class="card-text text-black">Di post oleh </span>
              <a class="card-text text-info" v-bind:href="base_url + 'user/' + post.poster">{{ post.poster }}</a>
              <p class="card-text pb-1">{{ post.report_count }} laporan</p>
              <div class="mt-3">
                <button v-on:click="delete_post(post, index)" class="btn btn-danger btn-md">Hapus</button>
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
      base_url: "<?= base_url("") ?>",
      errors: <?= json_encode($this->session->flashdata("error")) ?>,
      success: <?= json_encode($this->session->flashdata("success")) ?>,
      sort_state: "",
      posts: <?= json_encode($all_posts) ?>,
      username: "<?= $this->session->userdata("username") ?>",
    },
    created: function() {
      this.populatePostsData();
    },
    methods: {
      populatePostsData: function(i = 0) {
        let voteMap = new Map([
          ["Y", +1],
          ["-", 0],
          ["N", -1],
          [null, 0]
        ]);
        for (i; i < this.posts.length; i++) {
          let index = i;
          axios
            .all([
              this.username != "" ? this.getVoteState(index) : null, this.getVotes(index)
            ])
            .then(axios.spread((...response) => {
              vote_state = response[0] ? response[0].data.state : null;
              app.$set(app.posts[index],
                "state", vote_state);
              app.$set(app.posts[index],
                "vote", response[1].data.count - voteMap.get(vote_state));
              app.$set(app.posts[index],
                "reactive_vote", voteMap.get(vote_state));
              console.log(response[1].data.count);
            }))
            .catch(error => {
              console.log(error);
            })
        }
      },
      getVoteState: function(i) {
        return axios.get(`${this.base_url}/api/v1/get_vote_state/${this.username}/${this.posts[i].id}`);
      },
      getVotes: function(i) {
        return axios.get(`${this.base_url}/api/v1/get_votes/${this.posts[i].id}`);
      },
      removeElement: function(index) {
        this.posts.splice(index, 1);
      },
      delete_post: function(post, index) {
        axios
          .post(`${this.base_url}post/action/delete/${post.id}`)
          .then(response => {
            console.log(post.id + " telah didelete")
            this.removeElement(index)
          })
          .catch(error => {
            console.log("error report ", error);
          })
      },
    }
  });
</script>

</html>
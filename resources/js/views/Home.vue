<template>
  <div class="container">
    <h1>Content</h1>
    <hr />
    <div class="row">
      <div class="col-md-4" v-for="note in notes.data" :key="note.id">
        <router-link :to="{ name: 'notes.show', params: {noteSlug: note.slug} }">
          <div class="card mb-5 shadow mb-5 bg-white rounded" style="max-width: 540px;">
            <div class="row no-gutters">
              <div>
                <img :src="'img/profile/'+ note.image" class="card-img" alt="..." />
              </div>
              <div>
                <div class="card-body">
                  <h5 class="card-title">{{note.title}}</h5>
                  <small class="badge badge-success">Category</small>
                  <h6 class="text text-success">{{note.subject.name}}</h6>
                  <p class="card-text">
                    <small class="text-muted">{{note.created_at}}</small>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </router-link>
      </div>
    </div>
    <div v-if="notes.next_page_url">
      <button
        @click.prevent="paginate(notes.next_page_url)"
        type="button"
        class="btn btn-primary btn-block shadow rounded"
      >Load More</button>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      div: ["image"],
      notes: {}
    };
  },

  mounted() {
    this.getNotes();
    this.paginate();
  },

  methods: {
    async getNotes() {
      let { data } = await axios.get("/api/notes");
      this.notes = data.data;
    },

    get_image() {
      let photo =
        this.form.image.length > 100
          ? this.form.image
          : "img/profile/" + this.form.image;
      return photo;
    },

    paginate(url = "") {
      axios
        .get(url ? url : "/api/notes")
        .then(response => {
          if (!this.notes.data) {
            console.log(response.data);
            this.notes = response.data;
          } else {
            this.notes.data.push(...response.data.data);
            this.notes.next_page_url = response.data.next_page_url;
          }
        })
        .catch(e => console.error(e));
    }
  }
};
</script>

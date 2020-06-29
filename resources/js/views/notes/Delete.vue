<template>
  <button
    class="btn btn-danger btn-sm d-flex align-items-center"
    ref="deleteNote"
    @click="destroyNote"
  >
    <i class="fa fa-trash" aria-hidden="true"></i>
  </button>
</template>

<script>
import axios from "axios";
export default {
  props: ["endpoint"],
  loading: false,

  methods: {
    async destroyNote() {
      let q = window.confirm("Are you sure ?");
      if (q == true) {
        let response = await axios.delete(`/api/notes/${this.endpoint}/delete`);
        if (response.status == 200) {
          this.$toasted.show(response.data.massage, {
            type: "success",
            duration: "2000"
          });
          this.$refs.deleteNote.parentNode.parentNode.remove();
        }
      }
    }
  }
};
</script>


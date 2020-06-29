<template>
  <div class="col-md-6">
    <div class="card shadow rounded">
      <div class="card-header bg-primary text-white">New Note</div>
      <div class="card-body">
        <form action="#" method="post" @submit.prevent="store">
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" v-model="form.title" id="title" class="form-control" />
            <div v-if="theErrors.title" class="mt2 text-danger">{{theErrors.title[0]}}</div>
          </div>

          <div class="form-group">
            <label for="subject">Subject</label>

            <select v-model="form.subject" id="subject" class="form-control">
              <option
                v-for="subject in subjects"
                :key="subject.id"
                :value="subject.id"
              >{{ subject.name }}</option>
            </select>
            <div v-if="theErrors.subject" class="mt2 text-danger">{{theErrors.subject[0]}}</div>
          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea v-model="form.description" id="description" rows="5" class="form-control"></textarea>
            <div v-if="theErrors.description" class="mt2 text-danger">{{theErrors.description[0]}}</div>
          </div>

          <div class="form-group">
            <label for="image">Upload</label>
            <input type="file" @change="upload_image" name="image" id="image" class="form-control" />
            <div v-if="theErrors.image" class="mt2 text-danger">{{theErrors.image[0]}}</div>
            <div class="image img-fluid img-circle" style="margin-top:10px">
              <img :src="get_image()" v-bind:style="form.styleObject" />
            </div>
          </div>

          <button
            type="submit"
            class="btn btn-primary btn-sm d-flex align-items-center shadow rounded"
          >
            Save
            <template v-if="loading">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                xmlns:xlink="http://www.w3.org/1999/xlink"
                style="margin: auto; background: none; display: block; shape-rendering: auto;"
                width="30px"
                height="20px"
                viewBox="0 0 100 100"
                preserveAspectRatio="xMidYMid"
              >
                <rect x="17" y="25.9178" width="16" height="48.1644" fill="#dadfff">
                  <animate
                    attributeName="y"
                    repeatCount="indefinite"
                    dur="0.8403361344537814s"
                    calcMode="spline"
                    keyTimes="0;0.5;1"
                    values="9.199999999999996;26;26"
                    keySplines="0 0.5 0.5 1;0 0.5 0.5 1"
                    begin="-0.1680672268907563s"
                  />
                  <animate
                    attributeName="height"
                    repeatCount="indefinite"
                    dur="0.8403361344537814s"
                    calcMode="spline"
                    keyTimes="0;0.5;1"
                    values="81.60000000000001;48;48"
                    keySplines="0 0.5 0.5 1;0 0.5 0.5 1"
                    begin="-0.1680672268907563s"
                  />
                </rect>
                <rect x="42" y="25.339" width="16" height="49.3221" fill="#839aff">
                  <animate
                    attributeName="y"
                    repeatCount="indefinite"
                    dur="0.8403361344537814s"
                    calcMode="spline"
                    keyTimes="0;0.5;1"
                    values="13.399999999999999;26;26"
                    keySplines="0 0.5 0.5 1;0 0.5 0.5 1"
                    begin="-0.08403361344537814s"
                  />
                  <animate
                    attributeName="height"
                    repeatCount="indefinite"
                    dur="0.8403361344537814s"
                    calcMode="spline"
                    keyTimes="0;0.5;1"
                    values="73.2;48;48"
                    keySplines="0 0.5 0.5 1;0 0.5 0.5 1"
                    begin="-0.08403361344537814s"
                  />
                </rect>
                <rect x="67" y="24.0943" width="16" height="51.8114" fill="#dadfff">
                  <animate
                    attributeName="y"
                    repeatCount="indefinite"
                    dur="0.8403361344537814s"
                    calcMode="spline"
                    keyTimes="0;0.5;1"
                    values="13.399999999999999;26;26"
                    keySplines="0 0.5 0.5 1;0 0.5 0.5 1"
                  />
                  <animate
                    attributeName="height"
                    repeatCount="indefinite"
                    dur="0.8403361344537814s"
                    calcMode="spline"
                    keyTimes="0;0.5;1"
                    values="73.2;48;48"
                    keySplines="0 0.5 0.5 1;0 0.5 0.5 1"
                  />
                </rect>
              </svg>
            </template>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
export default {
  data() {
    return {
      form: {
        title: "",
        description: "",
        subject: "",
        image: "",
        styleObject: {
          width: "10%"
        }
      },
      loading: false,
      subjects: [],
      theErrors: []
    };
  },

  mounted() {
    this.getSubjects();
    this.get_image();
  },

  methods: {
    async getSubjects() {
      let response = await axios.get("/api/subjects");
      if (response.status === 200) {
        this.subjects = response.data;
      }
    },

    async store() {
      this.loading = true;
      try {
        let response = await axios.post(
          "/api/notes/create-new-note",
          this.form
        );
        if (response.status == 200) {
          this.form.title = "";
          this.form.description = "";
          this.form.subject = "";
          this.form.image = "";
          this.theErrors = [];
          this.$toasted.show(response.data.massage, {
            type: "success",
            duration: "2000"
          });
          this.loading = false;
        }
      } catch (e) {
        this.$toasted.show("Something went Wrong", {
          type: "error",
          duration: "2000"
        });
        this.theErrors = e.response.data.errors;
        this.loading = false;
      }
    },
    upload_image(e) {
      let file = e.target.files[0];
      let reader = new FileReader();

      if (file["size"] < 2111775) {
        reader.onloadend = file => {
          //console.log('RESULT', reader.result)
          this.form.image = reader.result;
        };
        reader.readAsDataURL(file);
      } else {
        alert("File size can not be bigger than 2 MB");
      }
    },
    get_image() {
      let photo =
        this.form.image.length > 100
          ? this.form.image
          : "img/profile/" + this.form.image;
      return photo;
    }
  }
};
</script>

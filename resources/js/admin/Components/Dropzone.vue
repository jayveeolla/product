<template>
  <form class="dropzone" :id="id">
    <div class="preview-template">
      <div class="dz-custom-preview">
        <div class="dz-details">
          <div class="dz-thumbnail">
            <img class="dz-image-preview img-thumbnail" data-dz-thumbnail />
          </div>
          <div class="dz-img-details">
            <div class="dz-filename"><span data-dz-name></span></div>
            <div class="dz-size text-muted">
              <span>Size:</span> <span data-dz-size></span>
            </div>
            <a class="mt-2 btn btn-danger btn-sm" data-dz-remove>
              <i class="fas fa-trash-alt"></i>
              Remove
            </a>
          </div>
        </div>

        <div class="dz-progress progress mt-2">
          <div
            data-dz-uploadprogress
            class="progress-bar bg-success"
            role="progressbar"
            style="width: 0%"
            aria-valuenow="50"
            aria-valuemin="0"
            aria-valuemax="100"
          ></div>
        </div>
        <div class="dz-error-message">
          <span data-dz-errormessage></span>
        </div>
      </div>
    </div>
    <div class="dz-message needsclick">
      <i class="fas fa-camera"></i> Add Images
    </div>
  </form>
</template>

<script>
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";
Dropzone.autoDiscover = false;

export default {
  emits: ["upload:xhrResponse", "upload:files"],
  props: {
    id: {
      default: "dropzone",
    },
    url: {
      default: "/upload",
    },
    collection: {
      default: "images",
    },
  },
  data: function () {
    return {
      myDropzone: null,
      files: [],
      xhrResponse: [],
    };
  },
  mounted: function () {
    var self = this;
    self.myDropzone = new Dropzone(`#${self.id}`, {
      url: self.url,
      thumbnailHeight: 120,
      thumbnailWidth: 120,
      headers: {
        "x-csrf-token": csrfToken,
      },
      previewTemplate: document.querySelector(".preview-template").innerHTML,
      init: function () {
        this.on("removedfile", function (file) {
          self.files = self.files.filter((data) => {
            if (data.upload.uuid == file.upload.uuid) {
              return false;
            }
            return true;
          });
          self.$emit("upload:files", self.files);

          // Handle response
          self.xhrResponse = [];
          self.files.forEach((data) => {
            if (data.xhr) {
              self.xhrResponse.push(JSON.parse(data.xhr.response));
            }
          });
          self.$emit("upload:xhrResponse", self.xhrResponse);
        });

        this.on("success", function (file) {
          self.files.push(file);
          self.$emit("upload:files", self.files);

          // Handle response
          self.xhrResponse = [];
          self.files.forEach((data) => {
            if (data.xhr) {
              self.xhrResponse.push(JSON.parse(data.xhr.response));
            }
          });
          self.$emit("upload:xhrResponse", self.xhrResponse);
        });

        this.on("sending", function (file, xhr, formData) {
          formData.append("collection_name", self.collection);
        });
      },
    });
  },
  methods: {
    resetFiles: function () {
      this.myDropzone.removeAllFiles();
      this.files = [];
      this.$emit("upload:files", this.files);
      this.xhrResponse = [];
      this.$emit("upload:xhrResponse", this.xhrResponse);
    },
  },
};
</script>

<style lang="scss">
.dropzone {
  border-width: 1px;
}
.preview-template {
  display: none;
}
.dz-custom-preview {
  border-bottom: 1px solid #000;

  &:last-child {
    border-bottom: 1px none;
  }
}
.dz-details {
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  width: 100%;
  padding-top: 0.45rem;
  padding-bottom: 0.45rem;

  .dz-thumbnail {
    width: 120px;
    .dz-image-preview {
      width: 120px;
      height: 120px;
      object-fit: cover;
    }
  }
  .dz-img-details {
    padding: 0.35rem 0.5rem;
  }
  .dz-img-details {
    flex: 1;
  }

  .dz-filename {
    font-weight: 500;
    font-size: 0.9rem;
  }

  .dz-size {
    font-weight: bold;
    font-size: 0.8rem;
  }
}
.dz-message {
  display: block !important;
  order: 1;
  padding: 2rem 1rem;
}
</style>
<template>
  <div class="quill">
    <div :id="toolbarId">
      <div class="ql-formats">
        <select class="ql-header">
          <option value="6"></option>
          <option value="5"></option>
          <option value="4"></option>
          <option value="3"></option>
          <option value="2"></option>
          <option value="1"></option>
        </select>

        <select class="ql-size">
          <option value="small"></option>
          <!-- Note a missing, thus falsy value, is used to reset to default -->
          <option selected></option>
          <option value="large"></option>
          <option value="huge"></option>
        </select>

        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
        <select class="ql-color"></select>

        <!--                <button class="ql-link"></button>-->
        <button class="ql-blockquote"></button>
        <!--                <button class="ql-code"></button>-->
        <button class="ql-image"></button>
        <button type="button" class="ql-list" value="ordered"></button>
        <button type="button" class="ql-list" value="bullet"></button>
        <button type="button" class="ql-link"></button>
      </div>
    </div>
    <div
      :style="{ height: height + 'px' }"
      :name="name"
      class="ql-editor"
      :id="editorId"
      ref="editor"
    ></div>
  </div>

  <div class="custom-file d-none">
    <input
      ref="image"
      @change="imageUpload($event)"
      type="file"
      class="custom-file-input"
      :id="fileInputName"
      aria-describedby="imageUploadAddon"
    />
    <label class="custom-file-label" for="imageUpload">Choose file</label>
  </div>
</template>
<script>
import { serialize } from "object-to-formdata";
import { runToast } from "@admin/Utils/notification";
import { ImageResize } from "quill-image-resize";

export default {
  emits: ["input"],
  name: "html-editor",
  props: {
    value: {
      type: String,
      default: "",
    },
    height: {
      type: String,
      default: "300",
    },
    name: String,
    hasImage: {
      type: Boolean,
      default: false,
    },
    routeName: {
      type: String,
    },
    fileInputName: {
      type: String,
    },
    label: {
      type: String,
    },
  },
  data: function () {
    return {
      content: null,
      toolbarId: null,
      editorId: null,
    };
  },
  watch: {
    value: function (val) {
      if (this.content != val) {
        this.$nextTick(() => {
          let refEditor = this.$refs.editor.children;
          if (refEditor.length > 0) {
            let node = refEditor[0];
            node.innerHTML = val;
          }
        });
      }
    },
  },
  methods: {
    randomString() {
      let text = "";
      let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";

      for (let i = 0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

      return text;
    },
    imageUpload(e) {
      if (e.target.files.length !== 0) {
        let quill = this.editor;
        let self = this;
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);

        reader.onloadend = function () {
          let params = serialize(
            {
              image: e.target.files[0],
            },
            {
              indices: true,
              booleansAsIntegers: true,
            }
          );

          let axios_config = {
            headers: {
              "content-type": "multipart/form-data",
            },
          };

          axios
            .post(self.routeName, params, axios_config)
            .then((data) => {
              let length = quill.getSelection().index;
              quill.insertEmbed(length, "image", data.data);
              quill.setSelection(length + 1);
              quill.setSelection(length + 1);
              quill.insertText(length + 1, "");
            })
            .catch((error) => {
              if (typeof error.response.data.errors !== "undefined") {
                runToast(
                  "top-right",
                  "warning",
                  error.response.data.errors.image[0]
                );
              }
            });
        };
      }
    },
  },
  unmounted: function () {
    // this.editor.des
  },
  mounted: function () {
    this.editorId = this.randomString();
    this.toolbarId = this.randomString();

    this.$nextTick(() => {
      let self = this;

      this.editor = new Quill(`#${this.editorId}`, {
        theme: "snow",
        modules: {
          toolbar: {
            container: `#${this.toolbarId}`,
            handlers: {
              image: function (value) {
                if (value) {
                  document.querySelector(`#${self.fileInputName}`).click();
                } else {
                  this.quill.format("image", false);
                }
              },
            },
          },
          imageResize: {
            displayStyles: {
              backgroundColor: "black",
              border: "none",
              color: "white",
            },
            modules: ["Resize", "DisplaySize", "Toolbar"],
          },
        },
      });

      let refEditor = this.$refs.editor.children;
      if (refEditor.length > 0) {
        let node = refEditor[0];

        this.editor.on("text-change", () => {
          let html = node.innerHTML;
          if (html === "<p><br></p>") {
            html = "";
          }
          this.content = html;
          this.$emit("input", this.content);
        });
      }
    });
  },
};
</script>
<style scoped>
.ql-editor strong {
  font-weight: bold;
}

.quill {
  display: flex;
  flex-direction: column;
}

.ql-editor {
  flex: 1;
  width: 100%;
  overflow-y: scroll;
  resize: vertical;
}

.quill-label {
  font-size: 0.875rem;
  font-weight: 600;
  color: #525f7f;
  margin-top: 10px;
}
</style>

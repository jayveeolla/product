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

        <button class="ql-bold"></button>
        <button class="ql-italic"></button>
        <button class="ql-underline"></button>
        <!--                <button class="ql-link"></button>-->
        <button class="ql-blockquote"></button>
        <!--                <button class="ql-code"></button>-->
        <button v-if="hasImage" class="ql-image"></button>
        <button type="button" class="ql-list" value="ordered"></button>
        <button type="button" class="ql-list" value="bullet"></button>
        <button type="button" class="ql-link"></button>
      </div>
    </div>
    <div
      :style="{ height: height + 'px' }"
      :name="name"
      class=""
      :id="editorId"
      ref="editor"
    ></div>
  </div>
</template>
<script>
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
  },
  mounted: function () {
    this.editorId = this.randomString();
    this.toolbarId = this.randomString();

    this.$nextTick(() => {
      this.editor = new Quill(`#${this.editorId}`, {
        theme: "snow",
        modules: {
          toolbar: `#${this.toolbarId}`,
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
</style>

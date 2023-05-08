<template>
  <component class="feather-svg-icon" :is="'span'" v-html="svgIcon" />
</template>

<script>
import feather from "feather-icons";
export default {
  name: "FeatherIcon",
  props: {
    icon: {
      default: null,
      required: true,
    },
    class: {
      default: "feather-16",
    },
    size: {
      default: null,
    },
  },
  computed: {
    svgIcon: function () {
      let option = {};
      return feather.icons[this.icon].toSvg({
        class: this.class,
        ...option,
      });
    },
  },
};
</script>

<style>
</style>
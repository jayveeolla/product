<template>
  <input
    v-bind="$attrs"
    :ref="ref"
    @focus="$emit('focus')"
    @blur="$emit('blur')"
  />
</template>

<script>
export default {
  props: {
    picker: {
      type: String,
      default: "datetime",
      validator: (value) => {
        let acceptedValues = ["datetime", "date", "time"];
        return acceptedValues.indexOf(value) !== -1;
      },
    },
  },
  computed: {
    ref: function () {
      return "datetimepicker" + this._uid;
    },
    inputDate() {
      return this.date;
    },
  },

  methods: {
    update(event) {
      this.$emit("input", event);
    },
    initializeDateTimePicker() {
      let now = moment();
      now.set({ hour: 0, minute: 0, second: 0, millisecond: 0 });

      let el = this.$refs[this.ref];
      let format = this.$headMeta("moment_datetime_format");
      let minDate = null;

      if (this.picker === "date") {
        format = this.$headMeta("moment_date_format");
        minDate = new Date();
      } else if (this.picker === "time") {
        format = this.$headMeta("moment_time_format");
      }

      let options = {
        ...(minDate && { minDate: moment().subtract(1, "days") }),
        format,
        icons: {
          time: "fa fa-clock-o",
          date: "fa fa-calendar",
          up: "fa fa-chevron-up",
          down: "fa fa-chevron-down",
          previous: "fa fa-chevron-left",
          next: "fa fa-chevron-right",
          today: "fa fa-screenshot",
          clear: "fa fa-trash",
          close: "fa fa-remove",
        },
      };

      // if (this.isToday) {
      // 	options.minDate = new Date();
      // }

      this.$jquery(el).datetimepicker(options);

      this.$jquery(el).on("dp.change", this.update);
    },
  },
  mounted() {
    this.initializeDateTimePicker();
  },
  beforeDestroy() {
    let el = this.$refs[this.ref];
    this.$jquery(el).off("dp.change", this.update);
  },
  beforeUpdate() {
    this.initializeDateTimePicker();
  },
};
</script>

<template>
  <div class="form-group">
    <slot name="label">
      <label v-if="label" :class="labelClasses">
        {{ label }}
        <span v-if="required">*</span>
      </label>
    </slot>

    <div
      :class="[
        {
          // 'has-danger': !!error,
          'input-group': hasIcon,
          'input-group-alternative': alternative,
          focused: focused,
          'has-label': label || $slots.label,
        },
        inputGroupClasses,
      ]"
    >
      <div v-if="addonLeftIcon || $slots.addonLeft" class="input-group-prepend">
        <span class="input-group-text">
          <slot name="addonLeft">
            <i :class="addonLeftIcon"></i>
          </slot>
        </span>
      </div>
      <slot>
        <input
          class="form-control"
          :name="name"
          :id="name"
          :type="type"
          :min="0"
          :placeholder="placeholder"
          :required="required"
          :readonly="readonly"
          :disabled="disabled"
          v-model="inputValue"
          @blur="focused = false"
          @focus="focused = true"
          :class="inputClasses"
          autocomplete="off"
        />
      </slot>
      <div
        v-if="addonRightIcon || $slots.addonRight"
        class="input-group-append"
      >
        <span class="input-group-text">
          <slot name="addonRight">
            <i :class="addonRightIcon"></i>
          </slot>
        </span>
      </div>
    </div>
    <slot name="infoBlock"></slot>
    <slot name="helpBlock">
       <div
        class="invalid-feedback"
        style="display: block;"
        :class="{ 'mt-2': hasIcon }"
        v-if="error"
      >
          <span v-if="typeof error === 'string'">{{error}}</span>
          <span v-if="typeof error === 'object'">
            <template v-for="(err, index) in error" :key="index">
              {{err}}
            </template>
          </span>
      </div>
    </slot>
  </div>
</template>

<script>
export default {
  name: "base-input",
  emits: ["update:modelValue",'change'],
  props: {
    addonRightIcon: String,
    addonLeftIcon: String,
    append: String,
    type: {
      type: String,
      default: "text",
    },
    modelValue: {
      type: String,
      default: "",
    },
    placeholder: {
      type: String,
      default: "",
    },
    name: {
      type: String,
      required: true,
    },
    label: {
      type: String,
    },
    required: {
      type: Boolean,
    },
    disabled: {
      type: Boolean,
    },
    readonly: {
      type: Boolean,
    },
    alternative: {
      type: Boolean,
      description: "Whether input is of alternative layout",
    },
    labelClasses: {
      type: String,
      description: "Input label css classes",
      default: "form-control-label",
    },
    inputGroupClasses: {
      type: String,
      default: "",
    },
    group: {
      type: String,
      default: "",
    },
    error: {
      default: null,
    },
    inputClasses: {
      type: String,
      default: "",
    },
  },
  data() {
    return {
      focused: false,
    };
  },
  computed: {
    hasIcon() {
      const { addonRight, addonLeft } = this.$slots;
      return (
        addonRight !== undefined ||
        addonLeft !== undefined ||
        this.addonRightIcon !== undefined ||
        this.addonLeftIcon !== undefined ||
        this.group
      );
    },
    inputValue: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
};
</script>

<style>

</style>

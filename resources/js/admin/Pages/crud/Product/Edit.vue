<template>
  <app-layout>
    <div class="container-fluid">
      <div class="content">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 d-inline-block mb-0">EDIT</h6>
            <nav
              aria-label="breadcrumb"
              class="d-none d-md-inline-block ml-md-4"
            ></nav>
          </div>
          <div class="col-lg-6 col-5 text-right" style="display: inline-block">
            <base-button
              style="width: 100.26px; height: 43.21px"
              tag="inertia-link"
              type="primary"
              :href="route('admin.product.index')"
              aria-pressed="true"
            >
              <i style="vertical-align: middle" class="ni ni-bold-left"></i>
              Back
            </base-button>
          </div>
        </div>
        <card>
          <form @submit.prevent="submit" enctype="multipart/form-data">
            <base-input
              label="Product Title"
              name="product_title"
              placeholder="Enter Product Title"
              :model-value="item.product_title"
              @update:model-value="setItemData({ key: 'product_title', value: $event })"
              :error="formErrors.product_title"
            ></base-input>

            <base-input
              label="Price"
              name="price"
              type="number"
              placeholder="Enter Price"
              :model-value="item.price"
              @update:model-value="setItemData({ key: 'price', value: $event })"
              :error="formErrors.price"
            ></base-input>

            <base-input
              label="Quanity"
              type="number"
              name="quanity"
              placeholder="Enter Quanity"
              :model-value="item.quanity"
              @update:model-value="
                setItemData({ key: 'quanity', value: $event })
              "
              :error="formErrors.quanity"
            ></base-input>

            
           
            <base-input
              name="Product Image"
              label="Upload Image"
              :error="formErrors.image"
            >
              <file-input
                placeholder="Enter Product Image"
                style="font-size: 0.875rem"
                :model-value="item.image"
                @change="setItemData({ key: 'image', value: $event })"
              ></file-input>
            </base-input>
           

          
            <base-input
              name="product_ingredients"
              label="Product Ingredients"
              :error="formErrors.product_ingredients || formErrors.images"
            >
              <html-editor
                :value="item.product_ingredients"
                @input="
                  setItemData({
                    key: 'product_ingredients',
                    value: $event,
                  })
                "
                :route-name="route('api.week.upload')"
                file-input-name="descriptionUpload"
              ></html-editor>
            </base-input>

           

            <base-input
              label="Sku"
              name="sku"
              placeholder="Enter Sku"
              :model-value="item.sku"
              @update:model-value="
                setItemData({ key: 'sku', value: $event })
              "
              :error="formErrors.sku"
            ></base-input>

            <base-button
              style="width: 100.26px; height: 43.21px"
              type="primary"
              native-type="submit"
              class="my-4 btn-primary"
              >Submit</base-button
            >
          </form>
        </card>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@admin/Layouts/AdministratorLayout";
import { mapGetters, mapActions } from "vuex";
import {
  ElSelect,
  ElOption,
  ElRadioGroup,
  ElRadio,
  ElRadioButton,
  ElColorPicker,
} from "element-plus";
import HtmlEditor from "@admin/Argon/components/Inputs/HtmlEditor";
import FileInput from "@admin/Argon/components/Inputs/FileInput";

export default {
  props: ["week"],
  components: {
    AppLayout,
    [ElSelect.name]: ElSelect,
    [ElOption.name]: ElOption,
    ElRadioGroup,
    ElRadio,
    ElRadioButton,
    ElColorPicker,
    HtmlEditor,
    FileInput,
  },
  data() {
    return {
      selectOptions: [
        {
          label: "Boy",
          value: "boy",
        },
        {
          label: "Girl",
          value: "girl",
        },
      ],
      predefineColors: [
        "#ff4500",
        "#ff8c00",
        "#ffd700",
        "#90ee90",
        "#00ced1",
        "#1e90ff",
        "#c71585",
        "rgba(255, 69, 0, 0.68)",
        "rgb(255, 120, 0)",
        "hsv(51, 100, 98)",
        "hsva(120, 40, 94, 0.5)",
        "hsl(181, 100%, 37%)",
        "hsla(209, 100%, 56%, 0.73)",
        "#c7158577",
      ],
    };
  },
  computed: {
    ...mapGetters("WeekSingle", ["item", "formErrors"]),
  },
  methods: {
    ...mapActions("WeekSingle", [
      "setItemData",
      "setItem",
      "updateData",
      "resetState",
    ]),
    async submit() {
      await this.updateData()
        .then((data) => {
          this.resetState();
          this.$inertia.get(route("admin.product.index"));
        })
        .catch((error) => {});
    },
  },
  mounted: function () {
    this.$nextTick(() => {
      this.setItem(this.week);
    });
  },
  unmounted: function () {
    this.resetState();
  },
};
</script>

<style>
.custom-control-label::before,
.custom-file-label,
.custom-select {
  font-size: 0.875rem !important;
}
</style>

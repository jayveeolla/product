<template>
  <app-layout>
    <div class="container-fluid">
      <div class="content">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 d-inline-block mb-0">VIEW</h6>
            <nav
              aria-label="breadcrumb"
              class="d-none d-md-inline-block ml-md-4"
            ></nav>
          </div>
          <div class="col-lg-6 col-5 text-right" style="display: inline-block">
            <base-button
              style="width: 100.26px; height: 43.21px"
              tag="a"
              type="primary"
              :href="route('admin.weeks.edit', week.id)"
              aria-pressed="true"
            >
              <i class="fas fa-pencil-alt"></i>
              Edit
            </base-button>
            <base-button
              style="width: 100.26px; height: 43.21px"
              tag="inertia-link"
              type="primary"
              :href="route('admin.weeks.index')"
              aria-pressed="true"
            >
              <i style="vertical-align: middle" class="ni ni-bold-left"></i>
              Back
            </base-button>
          </div>
        </div>
      </div>
      <card>
        <div class="table">
          <tbody>
            <tr>
              <td class="text-primary">ID</td>
              <td>
                {{ week.id }}
              </td>
            </tr>
            <tr>
              <td class="text-primary">Product Title</td>
              <td>
                {{ week.product_title }}
              </td>
            </tr>
            <tr>
              <td class="text-primary">Price</td>
              <td>
                {{ week.price }}
              </td>
            </tr>

            <tr>
              <td class="text-primary">Quantity</td>
              <td>
                {{ week.quanity }}
              </td>
            </tr>
            <tr>
              <td class="text-primary">SKU</td>
              <td>
                {{ week.sku }}
              </td>
            </tr>
            <tr>
              <td class="text-primary">Image</td>
              <td>
                <img
                  :src="week.photo"
                  class="img-thumbnail w-25"
                  alt=""
                  srcset=""
                />
              </td>
            </tr>
           
          
            <tr>
              <td class="text-primary">Product Description</td>
              <td>
                <span class="v-html" v-html="week.product_ingredients"></span>
              </td>
            </tr>
          
          </tbody>
        </div>
      </card>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@admin/Layouts/AdministratorLayout";
export default {
  props: ["week"],
  components: {
    AppLayout,
  },
};
</script>

<style >
.v-html * {
  color: #525f7f !important;
  font-size: 0.8125rem !important;
  font-weight: 400 !important;
  font-family: Open Sans, sans-serif !important;
}

.v-html img {
  max-width: 100% !important;
}
</style>
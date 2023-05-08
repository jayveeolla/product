<template>
  <app-layout>
    <div class="container-fluid">
      <div class="content">
        <div class="row align-items-center py-4">
          <div class="col-lg-6 col-7">
            <h6 class="h2 d-inline-block mb-0">Products</h6>
            <nav
              aria-label="breadcrumb"
              class="d-none d-md-inline-block ml-md-4"
            ></nav>
          </div>
          <div class="col-lg-6 col-5 text-right">
            <base-button
              style="width: 100.26px; height: 43.21px"
              tag="a"
              type="primary"
              :href="route('admin.product.create')"
              aria-pressed="true"
            >
              Create
            </base-button>
          </div>
        </div>
        <div>
          <card
            class="no-border-card"
            body-classes="px-0 pb-1"
            footer-classes="pb-2"
          >
            <div>
              <div
                class="
                  col-12
                  d-flex
                  justify-content-center justify-content-sm-between
                  flex-wrap
                "
              >
                <el-select
                  class="select-primary pagination-select"
                  :model-value="serverQuery.perPage"
                  @update:model-value="
                    setServerQuery({ name: 'perPage', value: $event })
                  "
                  placeholder="Per page"
                >
                  <el-option
                    class="select-primary"
                    v-for="item in pagination.perPageOptions"
                    :key="item"
                    :label="item"
                    :value="item"
                  >
                  </el-option>
                </el-select>
                <div>
                  <el-input
                    type="search"
                    class="mb-3"
                    clearable
                    prefix-icon="el-icon-search"
                    style="width: 200px"
                    placeholder="Search records"
                    :model-value="serverQuery.query"
                    @update:model-value="
                      setServerQuery({ name: 'query', value: $event })
                    "
                    aria-controls="datatables"
                  >
                  </el-input>
                </div>
              </div>
              <el-table
                :data="tableData"
                row-key="id"
                header-row-class-name="thead-light"
                @sort-change="handleSortChange"
              >
                <el-table-column min-width="200px" label="Image">
                  <template v-slot:default="props">
                    <img
                      class="img-thumbnail"
                      style="height: 100px !important; width: 100px !important"
                      :src="props.row.photo"
                      alt=""
                    />
                  </template>
                 
                           
                </el-table-column>

                <el-table-column min-width="200px" 
                  >
                  <template v-slot:default="props">
                   <a
                            class="dropdown-item"
                            :href="route('admin.product.edit', props.row.id)"
                          >
                          
                          </a>
                  </template>

                </el-table-column>
                         

                <el-table-column
                  v-for="column in tableColumns"
                  :key="column.label"
                  v-bind="column"
                >
                </el-table-column>

                <el-table-column min-width="200px" label="Actions">
                  <template v-slot:default="props">
                    <el-dropdown trigger="click" class="dropdown">
                      <span class="btn btn-sm btn-icon-only text-light">
                        <i class="fas fa-ellipsis-v mt-2"></i>
                      </span>
                      <template #dropdown>
                        <el-dropdown-menu v-if="props.row.id">
                          <inertia-link
                            class="dropdown-item"
                            :href="route('admin.product.show', props.row.id)"
                          >
                            <i class="fas fa-eye mr-1"></i>
                            View
                          </inertia-link>
                        
                          <a
                            class="dropdown-item"
                            :href="route('admin.product.edit', props.row.id)"
                          >
                            <i class="fas fa-pencil-alt mr-1"></i>
                            Edit
                          </a>
                          <a
                            class="dropdown-item text-danger"
                            @click="handleDelete(props.$index, props.row)"
                            href="#"
                          >
                            <i class="fas fa-trash mr-1"></i>
                            Delete
                          </a>
                        </el-dropdown-menu>
                      </template>
                    </el-dropdown>
                  </template>
                </el-table-column>
              </el-table>
            </div>
            <template v-slot:footer>
              <div
                class="
                  col-12
                  d-flex
                  justify-content-center justify-content-sm-between
                  flex-wrap
                "
              >
                <div class="">
                  <p class="card-category" v-if="pagination.total > 0">
                    Showing {{ pagination.from }} to {{ pagination.to }} of
                    {{ pagination.total }} entries
                  </p>
                </div>
                <base-pagination
                  class="pagination-no-border"
                  :model-value="serverQuery.page"
                  @update:model-value="
                    setServerQuery({ name: 'page', value: $event })
                  "
                  :per-page="pagination.perPage"
                  :total="pagination.total"
                >
                </base-pagination>
              </div>
            </template>
          </card>
        </div>
      </div>
    </div>
  </app-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import AppLayout from "@admin/Layouts/AdministratorLayout";
import swal from "sweetalert2";
import {
  ElTable,
  ElTableColumn,
  ElSelect,
  ElOption,
  ElInput,
  ElDropdownMenu,
  ElDropdownItem,
  ElDropdown,
  ElImage,
} from "element-plus";
import BasePagination from "@admin/Argon/components/BasePagination";

export default {
  components: {
    BasePagination,
    [ElSelect.name]: ElSelect,
    [ElOption.name]: ElOption,
    [ElTable.name]: ElTable,
    [ElInput.name]: ElInput,
    [ElTableColumn.name]: ElTableColumn,
    AppLayout,
    [ElDropdown.name]: ElDropdown,
    [ElDropdownItem.name]: ElDropdownItem,
    [ElDropdownMenu.name]: ElDropdownMenu,
  },
  computed: {
    ...mapGetters("WeekIndex", [
      "tableData",
      "pagination",
      "tableColumns",
      "perPageOptions",
      "serverQuery",
    ]),
  },
  methods: {
    ...mapActions("WeekIndex", [
      "fetchAllData",
      "setServerQuery",
      "destroyData",
      "setMultipleServerQuery",
      "resetState",
    ]),
    handleSortChange: function ({ column, prop, order }) {
      let orderDirection = null;
      if (order == "ascending") {
        orderDirection = "asc";
      } else if (order == "descending") {
        orderDirection = "desc";
      }
      this.setMultipleServerQuery([
        { name: "sort", value: prop },
        { name: "order", value: orderDirection },
      ]);
    },

    handleEdit: function (index, value) {},
    handleDelete: function (index, row) {
      const swalWithBootstrapButtons3 = swal.mixin({
        customClass: {
          confirmButton: "btn btn-success btn-fill",
          cancelButton: "btn btn-danger btn-fill",
        },
        buttonsStyling: false,
      });
      swalWithBootstrapButtons3
        .fire({
          title: "Are you sure?",
          text: `You won't be able to revert this!`,
          showCancelButton: true,
          confirmButtonText: "Yes, delete it!",
        })
        .then((result) => {
          if (result.value) {
            this.destroyData(row.id);
            swalWithBootstrapButtons3.fire({
              title: "Deleted!",
              text: `You deleted Product ${row.product_name}`,
            });
          }
        });
    },
  },
  mounted() {
    this.fetchAllData();
  },
  unmounted() {
    this.resetState();
  },
};
</script>
<style>
@media only screen and (max-width: 600px) {
 .el-input--prefix .el-input__inner {
    padding-left: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 4px;
    width: 103%;
}
}
</style>

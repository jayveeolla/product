import { debounce } from 'lodash'
import { runToast } from "@admin/Utils/notification";

function initialState() {
    return {
        tableData: [],
        serverQuery: {
            query: '',
            perPage: 10,
            page: 1,
        },
        pagination: {
            currentPage: 0,
            total: 0,
            perPage: 0,
            from: 0,
            to: 0,
            perPageOptions: [5, 10, 25, 50],
        },
        tableColumns: [
          
            {
                prop: "price",
                label: "price",
                minWidth: 200,
                sortable: 'custom'
            },                  
            {
                prop: "quanity",
                label: "quanity",
                minWidth: 200,
                sortable: 'custom'
            },

            {
                prop: "sku",
                label: "sku",
                minWidth: 200,
                sortable: 'custom'
            },
    
        ],
        loading: false,
    }
}

const getters = {
    tableData: state => state.tableData,
    pagination: state => state.pagination,
    tableColumns: state => state.tableColumns,
    serverQuery: state => state.serverQuery,
    loading: state => state.loading
}

const actions = {
    fetchData({ commit, state }) {
        commit('setLoading', true);
        axios.get(route(`api.weeks.index`, state.serverQuery))
            .then(response => {
                commit('setPagination', response.data)
                commit('setTableData', response.data.data)
            })
            .finally(function() {
                commit('setLoading', false);
            })
    },
    fetchAllData({ commit, state }) {             
        commit('setLoading', true);
        commit('setServerQuery', { name: 'all', value: true })
        axios.get(route(`api.weeks.index`))
            .then(response => {                             
                commit('setPagination', response.data)
                commit('setTableData', response.data.data)
            })
            .finally(function() {
                commit('setLoading', false);
            })
    },
    destroyData({ dispatch }, id) {
        axios.delete(route(`api.weeks.destroy`, id))
            .then(data => {
                runToast('top-right', 'warning', "Data has been removed")
                dispatch('delayServerQuery');
            })
    },
    setServerQuery({ commit, dispatch }, payload) {
        commit('setServerQuery', payload)
        dispatch('delayServerQuery');
    },
    setMultipleServerQuery({ commit, dispatch }, payload) {
        commit('setMultipleServerQuery', payload)
        dispatch('delayServerQuery');
    },
    delayServerQuery: debounce(({ dispatch }, text) => {
        dispatch("dispatchQueryString");
    }, 1000),
    dispatchQueryString({ dispatch }) {
        dispatch('fetchData');
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setPagination(state, { current_page, from, per_page, total, to }) {
        state.pagination.currentPage = current_page;
        state.pagination.total = total;
        state.pagination.perPage = parseInt(per_page);
        state.pagination.from = from;
        state.pagination.to = to;
    },
    setTableData(state, data) {
        state.tableData = data;
    },
    setQuery(state, query) {
        state.query = query
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    },
    setServerQuery(state, { name, value }) {
        state.serverQuery[name] = value
    },
    setMultipleServerQuery(state, arrValue) {
        state.tableColumns.map((data) => {
            data.className = ''
            return data;
        })
        Object(arrValue).forEach((item) => {
            let { name, value } = item;

            if (name == 'sort') {
                state.tableColumns.map((data) => {
                    if (value == data.prop) {
                        data.className = 'table-column-selected'
                    }
                    return data;
                })
            }
            state.serverQuery[name] = value;
        });
    },
    setLoading(state, status) {
        state.loading = status;
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
import axios from "axios"
import { runToast } from "@admin/Utils/notification";
import { serialize } from 'object-to-formdata';


function initialState() {
    return {
        item: {
            product_title: '',
            price: '',
            quanity: '',
            image: '',
            sku: '',
            product_ingredients: '',
        },
        formErrors: [],
        loading: false,
        axios_config: {
            headers: {
                'content-type': 'multipart/form-data'
            }
        }
    }
}

const getters = {
    item: state => state.item,
    loading: state => state.loading,
    formErrors: state => state.formErrors
}

const actions = {
    storeData({ commit, state }) {
        let params = serialize(state.item, {
            indices: true,
            booleansAsIntegers: true
        })
        params.set('_method', 'POST')
        return new Promise((resolve, reject) => {
            axios.post(route('api.weeks.store'), params, state.axios_config)
                .then(response => {
                    runToast('top-right', 'success', "Data has been saved.")
                    resolve(response)
                }).catch(error => {                    
                    if (typeof error.response.data.errors != 'undefined') {                         
                        commit('setFormErrors', error.response.data.errors)
                        runToast('top-right', 'warning', 'There is one or more error, please check the form and submit again.')
                    }
                    reject(error)
                });
        })
    },
    updateData({ commit, state }) {
        let params = serialize(state.item, {
            indices: true,
            booleansAsIntegers: true
        })
        params.set('_method', 'PATCH')
        return new Promise((resolve, reject) => {
            axios.post(route('api.weeks.update', state.item.id), params, state.axios_config)
                .then(response => {
                    runToast('top-right', 'success', "Changes saved.")
                    resolve(response)
                }).catch(error => {
                    if (typeof error.response.data.errors != 'undefined') {
                        commit('setFormErrors', error.response.data.errors)
                        runToast('top-right', 'warning', 'There is one or more error, please check the form and submit again.')
                    }
                    reject(error)
                });
        })
    },
    duplicateData({ commit, state }) {
        let params = serialize(state.item, {
            indices: true,
            booleansAsIntegers: true
        })
        params.set('_method', 'POST')
        return new Promise((resolve, reject) => {
            axios.post(route('api.weeks.store', state.item.id), params, state.axios_config)
                .then(response => {
                    runToast('top-right', 'success', "Data has been saved.")
                    resolve(response)
                }).catch(error => {
                    if (typeof error.response.data.errors != 'undefined') {
                        commit('setFormErrors', error.response.data.errors)
                        runToast('top-right', 'warning', 'There is one or more error, please check the form and submit again.')
                    }
                    reject(error)
                });
        })
    },
    setItem({ commit }, value) {
        commit('setItem', value)
    },
    setItemData({ commit }, value) {
        
        commit('setItemData', value)
    },
    setFormErrors({ commit }, value) {
        commit('setFormErrors', value)
    },
    resetState({ commit }) {
        commit('resetState')
    }
}

const mutations = {
    setItem(state, value) {
        state.item = value
    },
    setItemData(state, { key, value }) {
       
        if(key === 'image'){
            if(value.length > 0){
                state.item[key] = value[0];
            } else {
                state.item[key] =null;
            }
        } else {
            state.item[key] = value;
        }
        state.formErrors[key] = null;
    },
    setFormErrors(state, errors) {
        state.formErrors = errors;
    },
    setLoading(state, loading) {
        state.loading = loading
    },
    resetState(state) {
        state = Object.assign(state, initialState())
    }
}

export default {
    namespaced: true,
    state: initialState,
    getters,
    actions,
    mutations
}
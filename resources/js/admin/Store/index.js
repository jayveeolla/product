import { createStore } from 'vuex'

import WeekIndex from './Modules/Week'
import WeekSingle from './Modules/Week/Single'
const store = createStore({
    modules: {
       
        WeekIndex,
        WeekSingle,
       
    }
})
export default store;
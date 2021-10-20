import Vue from "vue";
import Vuex from 'vuex';
Vue.use(Vuex);

import state from '../post/state';
import mutations from '../post/mutations';
import actions from '../post/actions';
import getters from '../post/getters';

export default new Vuex.Store({
    state,
    mutations,
    actions,
    getters
});

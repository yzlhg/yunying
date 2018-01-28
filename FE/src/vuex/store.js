import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const state = {
  toKenCode:'123456'
}

const mutations = {
  storeSn(state, value) {
    state.toKenCode = value;
  }
}

export default new Vuex.Store(
  { state, mutations }
)
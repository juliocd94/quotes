import { createStore } from 'vuex';

const store = createStore({
  state() {
    return {
      user: typeof window !== 'undefined' ? JSON.parse(localStorage.getItem('user')) : null,
    access_token: typeof window !== 'undefined' ? localStorage.getItem('access_token') : null,
    };
  },
  mutations: {
    setUser(state, user) {
      state.user = user;
      if (typeof window !== 'undefined') {
        localStorage.setItem('user', JSON.stringify(user));
      }
    },
    clearUser(state) {
      state.user = null;
      if (typeof window !== 'undefined') {
        localStorage.removeItem('user');
      }
    },
    setAccessToken(state, access_token) {
      state.access_token = access_token;
      if (typeof window !== 'undefined') {
        localStorage.setItem('access_token', access_token);
      }
    },
    clearAccessToken(state) {
      state.access_token = null;
      if (typeof window !== 'undefined') {
        localStorage.removeItem('access_token');
      }
    },
  },
  actions: {
  },
  getters: {
  },
});

export default store;

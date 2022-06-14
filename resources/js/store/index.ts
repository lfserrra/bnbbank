import {createStore} from "vuex";

export type State = {
    helloMessage: string
};

export const store = createStore({
    state: <State>{
        helloMessage: 'Hello My friend'
    },
    mutations: {
        testeChange(state, payload: string) {
            state.helloMessage = payload;
        }
    },
    actions: {},
    getters: {},
    modules: {}
})

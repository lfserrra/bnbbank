import {createStore} from "vuex";

export type State = {
    showMenu: boolean
};

export const store = createStore({
    state: <State>{
        showMenu: false
    },
    mutations: {
        toggleMenu(state): void {
            state.showMenu = !state.showMenu;
        }
    },
    actions: {},
    getters: {},
    modules: {}
})

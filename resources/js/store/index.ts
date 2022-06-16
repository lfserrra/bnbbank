import {createStore} from "vuex";
import {UserTypeDTO} from "../dtos/User.dto";

export type State = {
    showMenu: boolean,
    user: UserTypeDTO
};

export const store = createStore({
    state: <State>{
        showMenu: false,
        user: {} as UserTypeDTO
    },
    mutations: {
        toggleMenu(state): void {
            state.showMenu = !state.showMenu;
        },

        setUser(state, payload: UserTypeDTO): void {
            state.user = payload

            const user = JSON.stringify(payload);

            localStorage.setItem('user', user);
        },

        logout(state): void {

        },
    },
    actions: {},
    getters: {},
    modules: {}
})

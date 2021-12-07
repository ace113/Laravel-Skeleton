import axios from "axios";

const state = {
    status: "",
    token: localStorage.getItem('bearer_token') ? JSON.parse(localStorage.getItem('bearer_token')) : '',
    userInfo: {},
};

const getters = {
    isLoggedIn: (state) => !!state.token,
    getToken: (state) => state.token,
    authStatus: (state) => state.status,
    getUserData: (state) => {
        return state.userInfo;
    },
    isAuthenticated: (state) => {
        if (state.userInfo) {
            return true;
        }
        return false;
    },
};

const mutations = {
    GET_USER_INFO(state, payload) {
        state.token = payload.access_token;
        state.userInfo = payload

        localStorage.setItem(
            "bearer_token",
            JSON.stringify(payload.access_token)
        );
        axios.defaults.headers.common['Authorization'] = payload.access_token
    },
    GET_PROFILE(state, payload) {
        state.userInfo = payload;
    },
    LOGOUT(state) {
        state.status = "";
        state.token = "";
        state.user = "";
        localStorage.removeItem("bearer_token");
        delete axios.defaults.headers.common["Authorization"];
        window.location.reload();
    },
};

const actions = {
    async userLogin(context, params) {
        console.log(params);
        try {
            const {
                data
            } = await axios.post("/api/v1/guest/login", params);
            if (data) {
                console.log(data.data);
                context.commit("GET_USER_INFO", data.data);
            }
        } catch (err) {
            console.log(err.response);
            localStorage.removeItem("bearer_token");
        }
    },
    async getProfile(context) {
        try {
            const {
                data
            } = await axios.get("/api/v1/auth/profile");
            if (data) {
                // console.log(data.data);
                context.commit("GET_PROFILE", data.data);
            }
            return data.data
        } catch (err) {
            console.log(err.response);
        }
    },
    async registerUser(context, params) {
        try {
            const {
                data
            } = axios.post('/api/v1/guest/register', params);
            if (data) {
                console.log(data.data)
                context.commit("");
            }
        } catch (err) {
            console.log(err.response)
        }
    },
    async logoutUser(context, params) {
        try {
            var device_id = params;
            const {
                data
            } = await axios.get(
                `/api/v1/auth/logout/${device_id}`
            );
            if (data) {
                console.log(data.data);
                context.commit("LOGOUT");
            }

        } catch (err) {
            console.log(err.response);
        }
    },
    async updateProfile(context, params) {
        try {
            const {
                data
            } = axios.post('/api/v1/auth/profile', params);
            if (data) {
                console.log(data.data)
                context.commit("");
            }
            return data.data;
        } catch (err) {
            console.log(err.response)
        }
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};
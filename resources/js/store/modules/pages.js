import axios from 'axios'

const state = {
    page: null,
}

const getters = {
    getPage: (state) => {
        return state.page;
    }
}

const mutations = {
    FETCH_PAGE(state, payload){
        state.page = payload
    }
}

const actions = {
    async getAboutPage(context){
        try {
            const { data } = await axios.get('/api/v1/guest/pages/about_us');
            if(data){
                console.log(data.data)
                context.commit('FETCH_PAGE', data.data);
            }
        } catch (err) {
            console.log(err.response)
            // throw err;
        }
    },
   
}

export default {
    state,
    getters,
    mutations,
    actions,
}
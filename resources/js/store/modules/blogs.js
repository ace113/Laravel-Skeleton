import axios from 'axios';
import { param } from 'jquery';
const state = {
    blogList: {},
    blog: {}
}

const getters = {
    getBlogList(state) {
        return state.blogList;
    },
    getBlog(state) {
        return state.blog;
    }
}

const mutations = {
    GET_BLOG_LIST(state, payload) {
        state.blogList = payload;
    },
    GET_BLOG(state, payload) {
        state.blog = payload;
    }
}

const actions = {
    
    async getBlogListRequest(context, params) {
        try {           
            const { data } = await
                axios
                    .get("/api/v1/guest/posts?page="+ params['page']+ "&per_page=" + params['per_page']);
            if (data) {
                // console.log(data.data.data);
                context.commit('GET_BLOG_LIST', data.data)
                return data.data;
            }
            return data.data;
        } catch (error) {
            throw error;
        }
    },
    async getBlogRequest(context, slug) {
        try {
            const { data } = await axios.get(`/api/v1/guest/posts/${slug}`);
            if (data) {
                console.log('blogc', data.data);
                context.commit('GET_BLOG', data.data)
                return data.data;
            }
            return data;
        } catch (error) {
            throw error;
        }
    },
    async getRecentBlogsRequest(context, params){
        try {
            const { data } = await axios.get('/api/v1/guest/posts/latest', params);
            if(data){
                return data.data;
            }
            return data.data;
        } catch (error) {
            throw error;
        }
    }
}

export default {
    state,
    getters,
    mutations,
    actions,
}
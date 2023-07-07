import axios from "axios";
import Form from "vform";

export default {
    getPosts ({ commit, state }) {
        return new Promise((resolve, reject) => {
            axios.get(`api/posts?page=${state.pagination.current_page}`)
                .then((response) => {
                    const pagination = response.data.meta
                    //step 2: commit the mutation(SET_POSTS)
                    commit('SET_POSTS', response.data.data)
                    //commit pagination info for further use
                    commit('SET_PAGE_NUMBER', pagination)
                    resolve(response)
                })
                .catch((error) => { reject(error) })
        })
    },
    savePost ({ commit }, blog) {
        return new Promise((resolve, reject) => {
            blog.post('api/posts')
                .then((response)=>{
                    if (response.data.status){
                        const post = response.data.data;
                        commit('ADD_POST', post)
                        resolve(response)
                    }
                })
                .catch((error) => { reject(error) })
        })
    },

    editPost ({ commit }, blog) {
        return new Promise((resolve, reject) => {
            //put method dont word if upload file so i used post method. If no need to upload file then can use put method(blog.put)
            blog.post('api/posts-update/'+blog.id)
                .then((response)=>{
                    if (response.data.status){
                        const post = response.data.data;
                        commit('EDIT_POST', post)
                        resolve(response)
                    }
                })
                .catch((error) => { reject(error) })
        })
    },

}

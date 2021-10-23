import axios from "axios";
import Form from "vform";

export default {
    getPosts ({ commit, state }) {
        console.log(state.pagination.current_page);
        return new Promise((resolve, reject) => {
                //?page='+this.pagination.current_page
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
                        console.log(response.data.data)
                        const post = response.data.data;
                        commit('ADD_POST', post)
                        resolve(response)
                    }
                })
                .catch((error) => { reject(error) })
        })
    },

}

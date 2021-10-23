import axios from "axios";
import Form from "vform";

export default {
    getPosts ({ commit, state }) {
        console.log(state.pagination.current_page);
        return new Promise((resolve, reject) => {
                //?page='+this.pagination.current_page
            axios.get(`api/posts?page=${state.pagination.current_page}`)
                //// 4th step: commit mutation(called SET_MEMBERSHIPS)
                .then((response) => {
                    const pagination = response.data.meta
                    //console.log(pagination)
                    commit('SET_POSTS', response.data.data)
                    commit('SET_PAGE_NUMBER', pagination)
                    resolve(response)
                })
                .catch((error) => { reject(error) })
        })
    },
    savePost ({ commit }, blog) {
        return new Promise((resolve, reject) => {
            //alert('adadad');
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

import axios from "axios";
import Form from "vform";

export default {
    getPosts ({ commit }) {
        return new Promise((resolve, reject) => {
            axios.get(`api/posts`)
                //// 4th step: commit mutation(called SET_MEMBERSHIPS)
                .then((response) => {
                    console.log(response.data.data)
                    commit('SET_POSTS', response.data.data)
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
                        //response = JSON.stringify(response.data.date)
                        //console.log(JSON.stringify(response.data.data))
                        console.log(response.data.data)
                        const post = response.data.data;
                        //console.log('saved'+ post)
                        //this.getData()
                        commit('ADD_POST', post)
                        resolve(response)
                    }
                })
                .catch((error) => { reject(error) })
        })
    },

}

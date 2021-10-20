import axios from "axios";

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
}

export default {
    SET_POSTS(state, posts){
        //step 3: update post array in state
        state.posts = posts
    },

    ADD_POST (state, post) {
        console.log(state.posts.push(Object.assign({}, post)))

        state.posts.push(Object.assign({}, post))
    },
    // set pagination info in state
    SET_PAGE_NUMBER(state, pagination){
        state.pagination = pagination
    }
    /*DELETE_POST(state, postId){
        const postIndex = state.posts.findIndex((post) => post.id === postId)
        state.posts.splice(postIndex, 1)
    },
    EDIT_POST(state, item){
        state.posts = state.posts.map(post => {
            if (post.id === item.id) {
                return Object.assign({}, post, item)
            }
            return post
        })
    },*/
}

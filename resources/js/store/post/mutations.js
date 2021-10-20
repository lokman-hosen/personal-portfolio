export default {
    SET_POSTS(state, posts){
        state.posts = posts
    },
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

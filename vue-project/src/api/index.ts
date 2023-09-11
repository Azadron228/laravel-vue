import request from '../utils/requests.ts'

function getPosts(page, author, favorited) {
    return request({
      url: '/posts',
      params: { 
        page,
        author,
        favorited,
      },
  }) 
};
function getPost(postId) {
  return request({
    url: `/post/${postId}`,
  })
}
function login(params: { user: User }) {
  return request({
    url: '/api/login',
    method: 'post',
    data: params,
  })
};
function register(params: { user: User }) {
  return request({
    url: '/api/register',
    method: 'post',
    data: params,
  })
};
function getUserInfo() {
    return request({
      url: '/posts',
  }) 
};
function updateUser(params: { user: UserInfo }) {
  return request({
    url: '/api/user',
    method: 'post',
    data: params,
  })
};
function createPost(params: { post: PostInfo }) {
  return request({
    url: '/post/create',
    method: 'post',
    data: params,
  })
}
function getProfile() {
    return request({
      url: '/posts',
  }) 
};
export default {
  getPosts,
  getPost,
  login,
  register,
  getProfile,
  getUserInfo,
  updateUser,
  createPost,
}

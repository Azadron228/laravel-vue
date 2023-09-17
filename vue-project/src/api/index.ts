import request from '../utils/requests.ts'

function getPosts(page, author, favorited, tags) {
    return request({
      url: '/posts',
      params: { 
        page,
        author,
        favorited,
        tags,
      },
  }) 
};
function getPost(postId) {
  return request({
    url: `/post/${postId}`,
  })
}
function getTags() {
  return request({
    url: `/listTags`,
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
  getTags,
  getPost,
  login,
  register,
  getProfile,
  getUserInfo,
  updateUser,
  createPost,
}

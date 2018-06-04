import axios from 'axios'
import qs from 'qs'
import store from '../store/index'

// 响应时间
axios.defaults.timeout = 5000
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
// axios.defaults.baseURL = 'http://local.xiaoshuobe.com'
axios.defaults.baseURL = 'http://xsbe.hjply.com'

// POST传参序列化(添加请求拦截器)
axios.interceptors.request.use(config => {
  store.state.isLoading = true
  if (config.method === 'post') {
    config.data = qs.stringify(config.data)
  }
  return config
  }, err => {
  store.state.isLoading = false
  return Promise.reject(err)
  }
)
// 返回状态判断(添加响应拦截器)
axios.interceptors.response.use(res => {
    if (res.status === 200) {
      store.state.isLoading = false
      return res
    } else {

    }
  }, err => {
  store.state.isLoading = false
  return Promise.reject(err)
  }
)

export default axios

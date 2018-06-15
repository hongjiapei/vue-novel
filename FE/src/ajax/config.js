import axios from 'axios'
import qs from 'qs'
import store from '../store/index'

// 响应时间
axios.defaults.timeout = 10000
axios.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=UTF-8'
// axios.defaults.baseURL = 'http://local.xiaoshuobe.com'
axios.defaults.baseURL = 'http://xsbe.hjply.com'

axios.defaults.retry = 1; //重试次数
axios.defaults.retryDelay = 1000;//重试延时
axios.defaults.shouldRetry = (error) => true;//重试条件，默认只要是错误都需要重试

// 请求拦截器：post传参序列化，同时从localStorage取出小说源
axios.interceptors.request.use((config)=>{
  store.state.isLoading = true
  const source = localStorage.getItem('source') || '001'
  if(config.method === 'post') {
    let data = qs.parse(config.data)
    config.data = qs.stringify({
      source: source,
      ...data
    })
  } else if(config.method === 'get') {
    config.params = {
      source: source,
      ...config.params
    }
  }
  return config;
}, (error)=>{
  store.state.isLoading = false
  return Promise.reject(error);
})

// 返回状态判断(添加响应拦截器) + 失败重试
axios.interceptors.response.use((res) => {
  if (res.status === 200) {
    store.state.isLoading = false
    store.state.isRetryShow = false
    return res
  }
}, (err) => {
  store.state.isLoading = false
  let config = err.config;
  // 判断是否配置了重试
  if(!config || !config.retry) return Promise.reject(err);
  if(!config.shouldRetry || typeof config.shouldRetry != 'function') {
    return Promise.reject(err);
  }
  //判断是否满足重试条件
  if(!config.shouldRetry(err)) {
    return Promise.reject(err);
  }
  // 设置重置次数，默认为0
  config.__retryCount = config.__retryCount || 0;
  // 判断是否超过了重试次数
  if(config.__retryCount >= config.retry) {
    store.state.isRetryShow = true
    store.state.retryText = '加载失败，请检查网络或者换源试试'
    setTimeout(()=>{
      store.state.isRetryShow = false
      store.state.retryText = '加载失败，自动重试中...'
    },2000)
    return Promise.reject(err);
  } else {
    store.state.isRetryShow = true
    store.state.retryText = '加载失败，自动重试中...'
  }
  //重试次数自增
  config.__retryCount += 1;
  //延时处理
  let backoff = new Promise(function(resolve) {
    setTimeout(function() {
      resolve();
    }, config.retryDelay || 1000);
  });
  //重新发起axios请求
  return backoff.then(function() {
    return axios(config);
  });
});

export default axios

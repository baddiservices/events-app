import axios from 'axios'
import router from '../../router'
import SecureLS from 'secure-ls'

const api = axios.create({
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    },
    baseURL: '/api/'
})

api.interceptors.response.use(null, error => {
    // Handle each response status
    switch(error.response.status){
        case 401:
            let ls = new SecureLS()
            ls.remove('user')
            ls.remove('token')
            router.replace('/')
        break
    }

    return Promise.reject(error)
})

export { api }
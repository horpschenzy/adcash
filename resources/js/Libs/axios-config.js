import axios from 'axios';

let token = JSON.parse(localStorage.getItem('bearerToken'));
const appAxios = axios.create({
    headers:{
        authorization: `Bearer ${token}`
    }
});

export const http = {
    get(url, data = {}, configs = {}) {
        return appAxios.get(url,{
            ...configs,
            params: data,
        })
    },

    post(url, data = {}, configs = {}) {
        return appAxios.post(url, data, configs)
    },

    put(url, data = {}, configs = {}) {
        return appAxios.put(url, data, configs)
    },

    delete(url, data = {}, configs = {}) {
        return appAxios.delete(url, data, configs)
    },
}

const onErrorResponse = async (error) => {
    if (error.response) {
        if (error.response.status === 401 &&  error.response.data.error === 'Unauthenticated.') {
            
            localStorage.removeItem('bearerToken');
            window.location = '/login'
        }else{
            return error.response;
        }
    }

    return error;
}

const onSuccessResponse = (response) => {
    // console.log(response);
    return response;
}

appAxios.interceptors.response.use(
    onSuccessResponse,
    onErrorResponse
)


export default http

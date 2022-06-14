import axios, {AxiosInstance} from 'axios'

const $axios: AxiosInstance = axios.create({
    baseURL: `http://test_turnover.test:8000/`,
    headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
    }
});

$axios.defaults.withCredentials = true;

export default $axios;

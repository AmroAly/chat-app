import axios from 'axios'
import Auth from '../store/auth'

export function get(url) {
    return axios({
        method: 'GET',
        url,
        headers: {
            Authorization: Auth.state.access_token
        }
    })
}

export function post(url, data) {
    return axios({
        method: 'POST',
        url,
        data,
        headers: {
            Authorization: Auth.state.access_token
        }
    })
}

export function delte(url) {
    return axios({
        method: 'DELETE',
        url,
        headers: {
            Authorization: Auth.state.access_token
        }
    })
}

export function daysBetweenTwoDates(d1, d2) {
    var oneDay = 24*60*60*1000;
    d1 = new Date(d1);
    d2 = new Date(d2);
    var days = Math.round(((d1.getTime() - d2.getTime())/(oneDay)));
    return days > 0 ? `${days} days left`: 'closed';
}
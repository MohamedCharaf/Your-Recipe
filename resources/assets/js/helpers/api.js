import axios from 'axios'
import Auth from '../store/auth'

export function post(url, data) {
	return axios({
		method: 'POST', 
		url,
		data,
		headers: {
			'Authorization': `Bearer ${Auth.state.api_token}`
		}
	});
}

export function put(url, data) {
	return axios({
		method: 'PUT', 
		url,
		data,
		headers: {
			'Authorization': `Bearer ${Auth.state.api_token}`
		}
	});
}

export function get(url) {
	return axios({
		method: 'GET', 
		url,
		headers: {
			'Authorization': `Bearer ${Auth.state.api_token}`
		}
	});
}

export function remove(url) {
	return axios({
		method: 'DELETE', 
		url,
		headers: {
			'Authorization': `Bearer ${Auth.state.api_token}`
		}
	});
}

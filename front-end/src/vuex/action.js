//actions.js
import axios from "axios";
import * as constant from './utils/constant';
import {

    API_ERROR_RESPONSE,
    API_SUCCESSFUL_RESPONSE,
    AUTH_REQUEST,
    AUTH_ERROR,
    AUTH_SUCCESS,
} 

from './mutation_types'

import {LOCAL_BASE_URL, OAUTH} from "./utils/constant";

export default {

    /**
     * IMPORTANT! here's the requirement code explanation
     * Here's my sample method for loading freelancer skill of users from mysql database and accessible via API using Laravel Passport. It uses user authorization access token 
     * provided by Laravel Passport and store the response via VueJs state management.
     * 
     * @param commit
     * @param data
     */

    loadFreelancerUserSkill({ commit}) {
        let user = JSON.parse(localStorage.getItem('user'));
        axios.get(constant.LOCAL_BASE_URL + `/api/v1/freelancer/${user.freelancer_id}/skills`, {
            headers: {
                Authorization: 'Bearer ' + user.authorization.access_token,
                'Content-Type': 'application/json',
            }
        }).then(({ data }) => {
            commit('getUserSkill', data.data ); /** This will store the value as getter and access it later */
        }).catch((error) => {
            if (error.response.status === 404) {
             
            }
        });
    },

    /**
     *
     * @param commit
     * @param data
     */
    authentication: ({commit}, data) => {
        commit(AUTH_REQUEST);
        axios.post(constant.LOCAL_BASE_URL + constant.OAUTH
            , {
                grant_type: constant.CLIENT_PASSWORD_GRANT_TYPE,
                client_id: constant.CLIENT_ID,
                client_secret: constant.CLIENT_SECRET,
                username: data.username,
                password: data.password
            })
            .then(response => {
                const user = response.data;
                localStorage.setItem('user', JSON.stringify(user));
                commit(AUTH_SUCCESS, user);

                switch(user.provider) {
                    case 'freelancer':
                        window.location.href= '/feed';
                        break;
                    case 'company':
                        window.location.href= '/freelancercompany/accountdetails';
                        break;
                    case 'employer':
                        window.location.href= '/employer/accountdetails';
                        break;
                    default:
                        window.location.href= '/login';
                }

            })
            .catch(error => {
                commit(AUTH_ERROR, error);
                localStorage.removeItem('user');
            });
    }
}

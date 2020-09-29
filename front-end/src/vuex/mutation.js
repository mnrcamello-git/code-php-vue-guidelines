//mutation.js
import * as types from './mutation_types';

export default {

    /**
     * Freelancer
     *
     * @param state
     * @param data
     */

    /** Method set as mutator which listen to any changes. This will just return the response taken from API which is PHP Laravel Passport accessing user skill data via model and returning it as json */
    getUserSkill (state, payload) {
        state.userskill = payload;
    },


}

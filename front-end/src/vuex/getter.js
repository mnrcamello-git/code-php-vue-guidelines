export default {
    /**
     * Getter Freelancer
     * @param state
     * @returns {{}|string}
     */

    isAuthenticated: state => !!state.auth,
    authStatus: state => state.status,

    /** Method set to getter. This will just return the response taken from API which is PHP Laravel Passport accessing user skill data via model and returning it as json */
    getUserSkill: function(state) {
        return state.userskill;
    }

}
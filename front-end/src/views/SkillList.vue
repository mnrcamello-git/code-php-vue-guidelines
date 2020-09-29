<template>
  <dashboard>
    <el-row :gutter="15">
      <el-col :xs="24" :md="24">
        <div class="skill-search">
          <el-card class="box-card" style="min-height: 493px;">
              <!-- Object view display for html bootstrap VueJs -->
            <Profile
              :userSkillLists="getUserSkills"
            />
            <related-categories v-show="showRelated" :related="related" @select="handleSelect" />
          </el-card>
        </div>
      </el-col>
    </el-row>
  </dashboard>
</template>

<script>
import Dashboard from "~/components/Dashboard/Dashboard";
import Selected from "./components/Selected";
//import Selection from "./components/Selection";
import PopularCategories from "./components/PopularCategories";
import RelatedCategories from "./components/RelatedCategories";
import Profile from "./components/Profile";
import { mapGetters } from "vuex";
import { SKILLS, LOCAL_BASE_URL, USER, SKILL_LIMIT, DEFAULT_RATE } from "~/vuex/utils/constant";
import axios from "axios";
import _ from "lodash";

export default {
  components: {
    Dashboard,
    Selected,
    //Selection,
    PopularCategories,
    RelatedCategories,
    Profile
  },
  created() {
    this.$store.dispatch("loadFreelancerUserSkill");  /** Trigger method from vuex/action.js */
    this.fetchUserSkills();
  },
  data() {
    return {
      labelPosition: "left",
      formLabelWidth: "120px",
      searchText: "",
      userSkillSelections: [],
      getUserSkills: [],

      form: {
        skill: "",
        email: ""
      },
      rules: {
        skillname: [
          { required: true, message: "Skill name is required", trigger: "blur" }
        ]
      },
    skills: [],
      timeout: null
    };
  },
  computed: {
    ...mapGetters({
      userSkillList: "getUserSkill" /** This call refers to vuex/action.js which initialize and set the property returned from our API user skills */
    })
  },
  methods: {
      /** This will assign data from API using axios get method */
    fetchUserSkills() {
      axios
        .get(
          LOCAL_BASE_URL + `/api/v1/freelancer/${USER.freelancer_id}/skills`,
          {
            headers: {
              Authorization: "Bearer " + USER.authorization.access_token
            }
          }
        )
        .then(({ data }) => {
          this.getUserSkills = data.data;
        })
        .catch(error => {
          if (error.response.status === 404) {
            //
          }
        });
    },
    /** UPDATE action on submitting buttons */
    formSubmission() {
      let error = false;
      // Revalidate if no error before submitting.
      this.$refs["skillForm"].validate(valid => {
        if (!valid) {
          error = true;
        }
      });
      // Abort there is an error
      if (error) return;
      this.dialogFormVisible = false;
      // Axios process begins here
    }
  },
  mounted() {}
};
</script>
<!-- CSS rendering with scope for this page only -->
<style lang="scss">
.my-autocomplete {
  li {
    line-height: normal;
    padding: 7px;

    .value {
      text-overflow: ellipsis;
      overflow: hidden;
    }
    .link {
      font-size: 12px;
      color: #b4b4b4;
    }
  }
}
.el-collapse,
.search .el-collapse-item__wrap,
.search .el-collapse-item__header {
  border: none;
}
.search {
  margin-bottom: 5px;
}
.search .el-card__body {
  padding: 0 20px;
}
.clickHere {
  cursor: pointer;
  color: #409eff;
}
</style>

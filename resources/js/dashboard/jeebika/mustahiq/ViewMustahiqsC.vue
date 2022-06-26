<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            View Mustahiqs
            <div class="card-header-actions p-0 m-0">
                <button class="btn btn-sm btn-ghost-danger" type="button" @click="reset('all')">
                    <span>Reset All</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Project </label>
                        <select v-model="search.project" class="w-100" @change="search.gro='';itemPerPageSelect()">
                            <option v-for="item in outputRes.projects" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> GRO </label>
                        <select v-model="search.gro" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.GROs" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Status </label>
                        <select v-model="search.status" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.STATUSES" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Gender </label>
                        <select v-model="search.gender" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.GENDERS" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Religion </label>
                        <select v-model="search.religion" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.RELIGIONS" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Blood Group </label>
                        <select v-model="search.bg" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.BLOOD_GROUPS" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Disability </label>
                        <select v-model="search.disability" class="w-100" @change="itemPerPageSelect()">
                            <option value="all_disable">All Disable</option>
                            <option value="all_not_disable">All Not Disable</option>
                            <option v-for="item in outputRes.disabilities" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Disease </label>
                        <select v-model="search.disease" class="w-100" @change="itemPerPageSelect()">
                            <option value="all_disease">All Disease</option>
                            <option value="all_not_disease">All Not Disease</option>
                            <option v-for="item in outputRes.diseases" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Regular Medicine </label>
                        <select v-model="search.rm" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.YES_NO" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Sponsor </label>
                        <select v-model="search.sponsor" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.sponsors" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Orphan </label>
                        <select v-model="search.orphan" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.ORPHAN_TYPES" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Pregnancy </label>
                        <select v-model="search.pregnancy" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.PREGNANCY_STATUSES" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Marital Status </label>
                        <select v-model="search.marital" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.MARITAL_STATUS" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Highest Education Level </label>
                        <select v-model="search.hel" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.EDUCATION_LEVELS" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Earn Ability </label>
                        <select v-model="search.ea" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.YES_NO" :key="item" :value="item">
                                {{ item }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Occupation </label>
                        <select v-model="search.occupation" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.occupations" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Permanent District </label>
                        <select v-model="search.ped" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.districts" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-6">
                    <div class="form-group"><label> Present District </label>
                        <select v-model="search.prd" class="w-100" @change="itemPerPageSelect()">
                            <option v-for="item in outputRes.districts" :key="item.id" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="pull-left">
                        <label class="d-inline-block">
                            Show
                            <select v-model="search.item" @change="itemPerPageSelect()">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="200">200</option>
                            </select>
                            entries
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="float-md-right">
                        <label>
                            Search: <input v-model="search.query" placeholder="Search..." type="text"
                                           @keyup="searchTimeOut()">
                        </label>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-responsive-sm table-sm table-striped table-hover">
                    <thead>
                    <tr>
                        <th style="width: 10px">#</th>
                        <th class="sort" style="width: 250px" @click="onClickSortItems('name')">Mustahiq Name</th>
                        <th>Gender</th>
                        <th>Religion</th>
                        <th>Blood Group</th>
                        <th>Sponsor</th>
                        <th>Orphan</th>
                        <th>Marital Status</th>
                        <th>Education</th>
                        <th>Occupation</th>
                        <th>Permanent District</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in outputRes.data" :key="index">
                        <td>{{ sl + index }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.gender }}</td>
                        <td>{{ item.religion }}</td>
                        <td>{{ item.blood_group }}</td>
                        <td>{{ getNameOf(item.sponsor_id, outputRes.sponsors) }}</td>
                        <td>{{ item.orphan_type }}</td>
                        <td>{{ item.marital_status }}</td>
                        <td>{{ item.highest_education_level }}</td>
                        <td>{{ getNameOf(item.occupation_id, outputRes.occupations) }}</td>
                        <td>{{ getNameOf(item.permanent_district_id, outputRes.districts) }}</td>
                        <td>
                            <span class='badge badge-success' v-if="'Active'===item.status">Active</span>
                            <span class='badge badge-warning' v-else-if="'Inactive'===item.status">Inactive</span>
                            <span class='badge badge-danger' v-else-if="'Blocked'===item.status">Blocked</span>
                            <span class="text-capitalize" v-else>{{ item.status }}</span>
                        </td>
                    </tr>
                    <tr v-if="outputRes.data.length === 0">
                        <td class="text-center" colspan="12">No Data Found</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="pull-left">
                        Showing
                        {{ outputRes.from ? outputRes.from : 0 }}
                        to
                        {{ outputRes.to ? outputRes.to : 0 }}
                        of
                        {{ outputRes.total ? outputRes.total : 0 }} entries
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <pagination v-if="outputRes.data.length>=0" :records="outputRes" class="pull-right"
                                @onclicked="paginationClicked"></pagination>
                </div>
            </div>
        </div>
        <div v-if="loading" class="czm-loader">Loading&#8230;</div>
    </div>
</template>

<script>
import Pagination from "../../Pagination.vue";
import queryString from "query-string";

export default {
    name: "ViewMustahiqsC",
    components: {Pagination},
    data() {
        return {
            loading: false,
            timeout: null,
            errors: {},
            sl: 1,
            search: {
                page: 1,
                sort: "name",
                type: "asc",
                query: "",
                item: "",
                project: "",
                gro: "",
                status: "",
                gender: "",
                religion: "",
                bg: "",
                disability: "",
                disease: "",
                rm: "",
                sponsor: "",
                orphan: "",
                pregnancy: "",
                marital: "",
                hel: "",
                ea: "",
                occupation: "",
                ped: "",
                prd: "",
            },
            outputRes: {
                data: [],
                projects: [],
                GROs: [],
                STATUSES: [],
                GENDERS: [],
                RELIGIONS: [],
                BLOOD_GROUPS: [],
                disabilities: [],
                diseases: [],
                YES_NO: [],
                sponsors: [],
                ORPHAN_TYPES: [],
                PREGNANCY_STATUSES: [],
                MARITAL_STATUS: [],
                EDUCATION_LEVELS: [],
                occupations: [],
                districts: [],
            },
            routes: window.appHelper.routes,
        };
    },

    methods: {
        reset() {
            Object.keys(this.search).forEach(key => this.search[key] = "")
            this.search.sort = "name";
            this.search.type = "asc";
            this.search.item = 25;
            this.itemPerPageSelect();
        },
        paginationClicked(page) {
            this.updateQueryParams("page", page);
            this.search.page = page;
            this.getAll();
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = key == "page" ? value : !!parsed.page ? parsed.page : 1;
            let sort = key == "sort" ? value : !!parsed.sort ? parsed.sort : "name";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "asc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let project =
                key == "project" ? value : !!parsed.project ? parsed.project : "";
            let gro = key == "gro" ? value : !!parsed.gro ? parsed.gro : "";
            let status =
                key == "status" ? value : !!parsed.status ? parsed.status : "";
            let gender =
                key == "gender" ? value : !!parsed.gender ? parsed.gender : "";
            let religion =
                key == "religion" ? value : !!parsed.religion ? parsed.religion : "";
            let bg = key == "bg" ? value : !!parsed.bg ? parsed.bg : "";
            let disability =
                key == "disability"
                    ? value
                    : !!parsed.disability
                        ? parsed.disability
                        : "";
            let disease =
                key == "disease" ? value : !!parsed.disease ? parsed.disease : "";
            let rm = key == "rm" ? value : !!parsed.rm ? parsed.rm : "";
            let sponsor =
                key == "sponsor" ? value : !!parsed.sponsor ? parsed.sponsor : "";
            let orphan =
                key == "orphan" ? value : !!parsed.orphan ? parsed.orphan : "";
            let pregnancy =
                key == "pregnancy" ? value : !!parsed.pregnancy ? parsed.pregnancy : "";
            let marital =
                key == "marital" ? value : !!parsed.marital ? parsed.marital : "";
            let hel = key == "hel" ? value : !!parsed.hel ? parsed.hel : "";
            let ea = key == "ea" ? value : !!parsed.ea ? parsed.ea : "";
            let occupation =
                key == "occupation"
                    ? value
                    : !!parsed.occupation
                        ? parsed.occupation
                        : "";
            let ped = key == "ped" ? value : !!parsed.ped ? parsed.ped : "";
            let prd = key == "prd" ? value : !!parsed.prd ? parsed.prd : "";

            let queryStringify = queryString.stringify({
                page,
                sort,
                type,
                query,
                item,
                project,
                gro,
                status,
                gender,
                religion,
                bg,
                disability,
                disease,
                rm,
                sponsor,
                orphan,
                pregnancy,
                marital,
                hel,
                ea,
                occupation,
                ped,
                prd,
            });
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams("page", this.search.page);
            this.updateQueryParams("item", this.search.item);
            this.updateQueryParams("project", this.search.project);
            this.updateQueryParams("gro", this.search.gro);
            this.updateQueryParams("status", this.search.status);
            this.updateQueryParams("gender", this.search.gender);
            this.updateQueryParams("religion", this.search.religion);
            this.updateQueryParams("bg", this.search.bg);
            this.updateQueryParams("disability", this.search.disability);
            this.updateQueryParams("disease", this.search.disease);
            this.updateQueryParams("rm", this.search.rm);
            this.updateQueryParams("sponsor", this.search.sponsor);
            this.updateQueryParams("orphan", this.search.orphan);
            this.updateQueryParams("pregnancy", this.search.pregnancy);
            this.updateQueryParams("marital", this.search.marital);
            this.updateQueryParams("hel", this.search.hel);
            this.updateQueryParams("ea", this.search.ea);
            this.updateQueryParams("occupation", this.search.occupation);
            this.updateQueryParams("ped", this.search.ped);
            this.updateQueryParams("prd", this.search.prd);
            this.getAll();
        },
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            _this.search.type = _this.search.type === "asc" ? "desc" : "asc";
            this.updateQueryParams("sort", key);
            this.updateQueryParams("type", _this.search.type);
            this.getAll();
        },
        searchTimeOut() {
            clearTimeout(this.timeout);
            this.timeout = setTimeout(() => {
                this.search.page = 1;
                this.updateQueryParams("page", this.search.page);
                this.updateQueryParams("query", this.search.query);
                this.getAll();
            }, 1000);
        },
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            _this.formData = {};
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.outputRes = res.data.lists;
                    _this.outputRes.projects = res.data.projects;
                    _this.outputRes.GROs = res.data.GROs;
                    _this.outputRes.STATUSES = res.data.STATUSES;
                    _this.outputRes.GENDERS = res.data.GENDERS;
                    _this.outputRes.RELIGIONS = res.data.RELIGIONS;
                    _this.outputRes.BLOOD_GROUPS = res.data.BLOOD_GROUPS;
                    _this.outputRes.disabilities = res.data.disabilities;
                    _this.outputRes.diseases = res.data.diseases;
                    _this.outputRes.YES_NO = res.data.YES_NO;
                    _this.outputRes.sponsors = res.data.sponsors;
                    _this.outputRes.ORPHAN_TYPES = res.data.ORPHAN_TYPES;
                    _this.outputRes.PREGNANCY_STATUSES = res.data.PREGNANCY_STATUSES;
                    _this.outputRes.MARITAL_STATUS = res.data.MARITAL_STATUS;
                    _this.outputRes.EDUCATION_LEVELS = res.data.EDUCATION_LEVELS;
                    _this.outputRes.occupations = res.data.occupations;
                    _this.outputRes.earnAbilities = res.data.earnAbilities;
                    _this.outputRes.districts = res.data.districts;
                    if (_this.search.page > 1) {
                        _this.sl = (_this.search.page - 1) * parseInt(_this.outputRes.per_page) + 1;
                    } else {
                        _this.sl = 1;
                    }
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.$setErrorsFromLaravel(error.response.data);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
    },
    created() {
        let parsed = queryString.parse(location.search);
        this.search.page = !!parsed.page ? parsed.page : 1;
        this.search.sort = !!parsed.sort ? parsed.sort : "name";
        this.search.type = !!parsed.type ? parsed.type : "asc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.search.project = !!parsed.project ? parsed.project : "";
        this.search.gro = !!parsed.gro ? parsed.gro : "";
        this.search.status = !!parsed.status ? parsed.status : "";
        this.search.gender = !!parsed.gender ? parsed.gender : "";
        this.search.religion = !!parsed.religion ? parsed.religion : "";
        this.search.bg = !!parsed.bg ? parsed.bg : "";
        this.search.disability = !!parsed.disability ? parsed.disability : "";
        this.search.disease = !!parsed.disease ? parsed.disease : "";
        this.search.rm = !!parsed.rm ? parsed.rm : "";
        this.search.sponsor = !!parsed.sponsor ? parsed.sponsor : "";
        this.search.orphan = !!parsed.orphan ? parsed.orphan : "";
        this.search.pregnancy = !!parsed.pregnancy ? parsed.pregnancy : "";
        this.search.marital = !!parsed.marital ? parsed.marital : "";
        this.search.hel = !!parsed.hel ? parsed.hel : "";
        this.search.ea = !!parsed.ea ? parsed.ea : "";
        this.search.occupation = !!parsed.occupation ? parsed.occupation : "";
        this.search.ped = !!parsed.ped ? parsed.ped : "";
        this.search.prd = !!parsed.prd ? parsed.prd : "";
        this.getAll();
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        }
    },
};
</script>

<style scoped>
</style>

<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Mustahiq Reports
            <div class="card-header-actions p-0 m-0">
                <button class="btn btn-sm btn-ghost-danger" type="button" @click="reset('all')">
                    <span>Reset All</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label class="mb-0">Project</label>
                    <select v-model.number="formData.j_project_id" class="form-control form-control-sm rounded-0"
                            @change="getGROs()">
                        <option value="">All</option>
                        <option v-for="item in initData.projects" :key="item.id" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">GRO</label>
                    <select v-model.number="formData.j_gro_id" class="form-control form-control-sm rounded-0"
                            @change="getFamilies()">
                        <option value="">All</option>
                        <option v-for="item in initData.GROs" :key="item.id" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Family</label>
                    <select v-model.number="formData.family_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.families" :key="item.family_id" :value="item.family_id">
                            {{ item.family ? item.family.name : 'AAA' }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Status</label>
                    <select v-model.number="formData.status" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.mustahiqStatuses" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Gender</label>
                    <select v-model.number="formData.gender" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.genders" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Religion</label>
                    <select v-model.number="formData.religion" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.religions" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Blood Group</label>
                    <select v-model.number="formData.blood_group" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.bloodGroups" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Marital Status</label>
                    <select v-model.number="formData.marital_status" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.maritalStatuses" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Orphan Type</label>
                    <select v-model.number="formData.orphan_type" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option class="text-success" value="all_not_orphan">All Not Orphan</option>
                        <option class="text-danger" value="all_orphan">All Orphan</option>
                        <option v-for="item in initData.orphanTypes" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Earn Ability</label>
                    <select v-model="formData.is_earn_ability" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Disability</label>
                    <select v-model.number="formData.disability_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option class="text-success" value="all_not_disable">All Not Disable</option>
                        <option class="text-danger" value="all_disable">All Disability</option>
                        <option v-for="(item,index) in initData.disabilities" :key="index" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Disease</label>
                    <select v-model.number="formData.disease_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option class="text-success" value="all_not_disease">All Not Disease</option>
                        <option class="text-danger" value="all_disease">All Disease</option>
                        <option v-for="(item,index) in initData.diseases" :key="index" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Regular Medicine</label>
                    <select v-model="formData.is_disease_regular_medicine"
                            class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Occupation</label>
                    <select v-model.number="formData.occupation_id" class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="(item,index) in initData.occupations" :key="index" :value="item.id">
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Highest Education Level</label>
                    <select v-model.number="formData.highest_education_level"
                            class="form-control form-control-sm rounded-0">
                        <option value="">All</option>
                        <option v-for="item in initData.educations" :key="item" :value="item">
                            {{ item }}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label style="text-align:left;">
                        Age Range
                        <span style="float:right; padding-left: 10px">
              <a class="text-danger" style="cursor: pointer" @click="reset('age')">Reset</a>
            </span>
                    </label>
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <select ref="fromYear" v-model.number="formData.age_from"
                                    :class="[(vvErrors.has('age_from') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0" data-vv-as="from year"
                                    data-vv-name="age_from"
                                    name="age_from">
                                <option value="">From</option>
                                <option v-for="(item,index) in Array(70).keys()" :key="index" :value="item+1">
                                    {{ item + 1 + ' Year' }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('age_from')" class="invalid-feedback">
                                {{ vvErrors.first('age_from') }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <select v-model.number="formData.age_to" v-validate="'greaterThen:'+this.formData.age_from"
                                    :class="[(vvErrors.has('age_to') ? 'is-invalid' : '')]"
                                    class="form-control form-control-sm rounded-0"
                                    data-vv-as="to year"
                                    data-vv-name="age_to"
                                    name="age_to">
                                <option value="">To</option>
                                <option v-for="(item,index) in Array(70).keys()" :key="index" :value="item+1">
                                    {{ item + 1 + ' Year' }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('age_to')" class="invalid-feedback">
                                {{ vvErrors.first('age_to') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-5"></div>
            <div class="row">
                <!--                <div class="col-md-2">
                                    <button class="btn btn-sm btn-outline-primary d-block rounded-0 w-100 mb-1" type="button"
                                            @click="download('pdf')">
                                        Download PDF
                                    </button>
                                </div>-->
                <div class="col-md-2 offset-md-3">
                    <button class="btn btn-sm btn-outline-info d-block rounded-0 w-100 mb-1" type="button"
                            @click="download('xls')">
                        Download XLS
                    </button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-sm btn-outline-success d-block rounded-0 w-100" type="button"
                            @click="download('view')">
                        View
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "MustahiqReportC",
    data() {
        return {
            loading: false,
            formData: {
                j_project_id: "",
                j_gro_id: "",
                family_id: "",
                status: "",
                age_from: "",
                age_to: "",
                gender: "",
                religion: "",
                highest_education_level: "",
                is_earn_ability: "",
                disability_id: "",
                occupation_id: "",
                disease_id: "",
                is_disease_regular_medicine: "",
                blood_group: "",
                marital_status: "",
                orphan_type: "",
            },
            initData: {
                genders: [],
                religions: [],
                disabilities: [],
                occupations: [],
                educations: [],
                mustahiqStatuses: [],
                maritalStatuses: [],
                orphanTypes: [],
                diseases: [],
                bloodGroups: [],
                projects: [],
                GROs: [],
                families: [],
            },
            int: 0,
            errors: {},
            routes: window.appHelper.routes,
        };
    },
    methods: {
        reset(key) {
            let _this = this;
            if (key == "age") {
                _this.formData.age_from = "";
                _this.formData.age_to = "";
            }
            if (key == "all") {
                _this.formData.j_project_id = "";
                _this.formData.j_gro_id = "";
                _this.formData.family_id = "";
                _this.formData.status = "";
                _this.formData.gender = "";
                _this.formData.religion = "";
                _this.formData.disability_id = "";
                _this.formData.occupation_id = "";
                _this.formData.highest_education_level = "";
                _this.formData.is_earn_ability = "";
                _this.formData.disease_id = "";
                _this.formData.is_disease_regular_medicine = "";
                _this.formData.blood_group = "";
                _this.formData.marital_status = "";
                _this.formData.orphan_type = "";
                _this.reset("age");
            }
        },
        getGROs() {
            let _this = this;
            _this.loading = true;
            _this.formData.j_gro_id = "";
            _this.formData.family_id = "";
            _this.initData.GROs = [];
            _this.initData.families = [];
            axios.post(_this.routes.searchGROByProjectId, {'j_project_id': _this.formData.j_project_id}).then((res) => {
                if (res.data) {
                    _this.initData.GROs = res.data;
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
        getFamilies() {
            let _this = this;
            _this.loading = true;
            _this.formData.family_id = "";
            _this.initData.families = [];
            axios.post(_this.routes.getFamiliesByProjectAndOrGRO, {
                'j_project_id': _this.formData.j_project_id,
                'j_gro_id': _this.formData.j_gro_id
            }).then((res) => {
                if (res.data) {
                    _this.initData.families = res.data;
                    this.$forceUpdate();
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
        getAll() {
            let _this = this;
            _this.loading = true;
            axios.post(_this.routes.init).then((res) => {
                if (res.data) {
                    _this.initData = res.data;
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
        checkValid() {
            let _this = this;
            let flag = true;
            let message = [];
            if (_this.formData.age_from && _this.formData.age_to == "") {
                message.push("Please select age rage to year.");
                flag = false;
            }
            if (_this.formData.age_to && _this.formData.age_from == "") {
                message.push("Please select age rage from year.");
                flag = false;
            }
            if (!flag) {
                toastr.error(message, "Error");
            }
            return flag;
        },
        download(key) {
            let _this = this;
            if (_this.checkValid()) {
                _this.veeValid(key);
            }
        },
        veeValid(key) {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.downloadNow(key);
                }
            });
        },
        downloadNow(key) {
            let _this = this;
            _this.loading = true;
            _this.formData.report_type = key;
            if (key == "pdf" || key == "xls") {
                axios({
                    method: "POST",
                    url: _this.routes.download,
                    responseType: "blob",
                    data: _this.formData,
                }).then(function (response) {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", response.headers.file_name);
                    document.body.appendChild(link);
                    link.click();
                    _this.loading = false;
                }).catch((error) => {
                    let b = new Blob([error.response.data], {type: "application/json"}),
                        fr = new FileReader();
                    fr.onload = function () {
                        let error = JSON.parse(this.result);
                        toastr.error(error.message, "Error");
                        _this.errors = error.errors;
                    };
                    fr.readAsText(b);
                    _this.loading = false;
                });
            } else {
                axios.post(_this.routes.download, _this.formData).then((res) => {
                    var myWindow = window.open("", _this.int + "_window");
                    myWindow.document.write(res.data);
                    _this.loading = false;
                    _this.int++;
                }).catch((err) => {
                    toastr.error(err.response.data.message, "Error");
                    if (err.response && err.response.data.errors) {
                        _this.errors = err.response.data.errors;
                    }
                    _this.loading = false;
                });
            }
        },
    },
    created() {
        this.getAll();
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        },
        dateTimeFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY, hh:mm a");
        },
        textCapitalize(value) {
            if (!value) return "";
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1);
        },
    },
};
</script>

<style scoped>
</style>

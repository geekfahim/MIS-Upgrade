<template>
    <div class="position-relative">
        <div v-if="!isEmpty(errors)" class="alert alert-danger alert-dismissible fade show" role="alert">
            <div v-html="errorHtml"></div>
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="row mb-1">
            <div class="col-xl-3 col-md-3 col-sm-6">
                <select v-model="j_project_id" v-validate="'required'"
                        :class="[(this.vvErrors.has('j_project_id') ? 'is-invalid' : '')]"
                        class="form-control form-control-sm rounded-0"
                        data-vv-as="project" data-vv-name="j_project_id"
                        @change="getGROs">
                    <option value="">Select Project</option>
                    <option v-for="(item,index) in initData.projects" :key="index" :value=item.id>
                        {{ item.name }}
                    </option>
                </select>
                <div v-show="vvErrors.has('j_project_id')" class="invalid-feedback">
                    {{ vvErrors.first('j_project_id') }}
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-6">
                <select v-model="j_gro_id" v-validate="'required'"
                        :class="[(this.vvErrors.has('j_gro_id') ? 'is-invalid' : '')]"
                        class="form-control form-control-sm rounded-0" data-vv-as="gro"
                        data-vv-name="j_gro_id">
                    <option value="">Select GRO</option>
                    <option v-for="(item,index) in initData.GROs" :key="index" :value=item.id>
                        {{ item.name }}
                    </option>
                </select>
                <div v-show="vvErrors.has('j_gro_id')" class="invalid-feedback">
                    {{ vvErrors.first('j_gro_id') }}
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-6">
                <select v-model="j_sponsor_id" v-validate="'required'"
                        :class="[(this.vvErrors.has('j_sponsor_id') ? 'is-invalid' : '')]"
                        class="form-control form-control-sm rounded-0" data-vv-as="sponsor"
                        data-vv-name="j_sponsor_id">
                    <option value="">Select Sponsor</option>
                    <option v-for="(item,index) in initData.sponsors" :key="index" :value=item.id>
                        {{ item.name }}
                    </option>
                </select>
                <div v-show="vvErrors.has('j_sponsor_id')" class="invalid-feedback">
                    {{ vvErrors.first('j_sponsor_id') }}
                </div>
            </div>
            <div class="col-xl-3 col-md-3 col-sm-6">
                <button class="btn btn-sm btn-czm-blue pull-left w-100" @click="submit()">
                    Submit
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="nav-tabs-boxed">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
                        <li class="nav-item">
                            <a id="personal-tab" aria-controls="personal" aria-selected="true"
                               class="nav-link active show"
                               data-toggle="tab" href="#personal" role="tab">
                                Personal
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="family-tab" aria-controls="personal" aria-selected="true" class="nav-link"
                               data-toggle="tab"
                               href="#family" role="tab">
                                Family Info
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="family-asset-tab" aria-controls="family_asset" aria-selected="true" class="nav-link"
                               data-toggle="tab" href="#family_asset" role="tab">
                                Family Asset & Liabilities
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="family-income-tab" aria-controls="family_income" aria-selected="true"
                               class="nav-link"
                               data-toggle="tab" href="#family_income" role="tab">
                                Family Income and Expense
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="ngo-tab" aria-controls="ngo" aria-selected="true" class="nav-link" data-toggle="tab"
                               href="#ngo" role="tab">
                                Other NGO Engagement
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="safety-tab" aria-controls="safety" aria-selected="true" class="nav-link"
                               data-toggle="tab"
                               href="#safety" role="tab">
                                Family Safety & Aid
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="disaster-tab" aria-controls="disaster" aria-selected="true" class="nav-link"
                               data-toggle="tab"
                               href="#disaster" role="tab">
                                Disaster
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="personal" aria-labelledby="personal-tab" class="tab-pane fade active show"
                             role="tabpanel">
                            <PersonalCreateC @mustahiq-add="mustahiqAdd"></PersonalCreateC>
                        </div>
                        <div id="family" aria-labelledby="family-tab" class="tab-pane fade" role="tabpanel">
                            <FamilyInfoCreateC></FamilyInfoCreateC>
                        </div>
                        <div id="family_asset" aria-labelledby="family-asset-tab" class="tab-pane fade" role="tabpanel">
                            <FamilyAssetCreateC></FamilyAssetCreateC>
                        </div>
                        <div id="family_income" aria-labelledby="family-income-tab" class="tab-pane fade"
                             role="tabpanel">
                            <FamilyIncomeCreateC></FamilyIncomeCreateC>
                        </div>
                        <div id="ngo" aria-labelledby="ngo-tab" class="tab-pane fade" role="tabpanel">
                            <NgoCreateC></NgoCreateC>
                        </div>
                        <div id="safety" aria-labelledby="safety-tab" class="tab-pane fade" role="tabpanel">
                            <SafetyCreateC></SafetyCreateC>
                        </div>
                        <div id="disaster" aria-labelledby="disaster-tab" class="tab-pane fade" role="tabpanel">
                            <DisasterCreateC></DisasterCreateC>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loading" class="czm-loader">Loading&#8230;</div>
    </div>
</template>

<script>
import PersonalCreateC from "./PerosnalCreateC";
import FamilyInfoCreateC from "./FamilyInfoCreateC";
import FamilyAssetCreateC from "./FamilyAssetCreateC";
import FamilyIncomeCreateC from "./FamilyIncomeCreateC";
import NgoCreateC from "./NgoCreateC";
import SafetyCreateC from "./SafetyCreateC";
import DisasterCreateC from "./DisasterCreateC";
import Select2 from "v-select2-component";

export default {
    name: "MustahiqFamilyCreateC",
    components: {
        Select2,
        FamilyInfoCreateC,
        PersonalCreateC,
        FamilyAssetCreateC,
        FamilyIncomeCreateC,
        NgoCreateC,
        SafetyCreateC,
        DisasterCreateC
    },
    inject: ["$validator"],
    data() {
        return {
            loading: false,
            j_project_id: "",
            j_gro_id: "",
            j_sponsor_id: "",
            initData: {
                projects: [],
                GROs: [],
                sponsors: [],
                maritalStatuses: [],
                relationalLivingStatus: [],
                educationLevels: [],
                vocationals: [],
                skills: [],
                genders: [],
                pregnancyStatuses: [],
                orphanTypes: [],
                religions: [],
                bloodGroups: [],
                disabilities: [],
                diseases: [],
                familyRelationTypes: [],
                occupations: [],
                districts: [],
                unions: [],
                //family info
                familyHeadedByTypes: [],
                houseTypes: [],
                houseLandTypes: [],
                houseLocations: [],
                drinkingWaterSources: [],
                otherWaterSources: [],
                toiletOwnershipTypes: [],
                toiletTypes: [],
                cookingFuelTypes: [],
                electricityConnectivityTypes: [],
                //family savings
                savingsTypes: [],
                assets: [],
                loanSourceTypes: [],
                loanPurposeTypes: [],
                //family income & expense
                incomes: [],
                expenseTypes: [],
                //family NGO
                ngoHelpTypes: [],
                //family safety & helpfulness
                abuseTypes: [],
                abuserRelationTypes: [],
                neighborHelpTypes: [],
                richHelpTypes: [],
                conflictResolveTypes: [],
                //family disaster & recovery
                disasters: [],
                disasterLevels: [],
                recoveries: [],
            },
            formData: {
                family_headed_by: "",
                total_room: "",
                house_type: "",
                house_land_type: "",
                house_location: "",
                drinking_water: "",
                other_water: "",
                toilet_type: "",
                toilet_owner: "",
                cooking_fuel: "",
                electricity_connectivity: "",
                family_reference_number: "",
                mustahiqs: [],
                familyMembers: [],
                familyAssets: [],
                familyLoans: [],
                familyIncomes: [],
                familyExpenses: [],
                familySavings: [],
                familyOtherNgos: [],
                familySafeties: [],
                familyNeighborHelps: [],
                familyRichHelps: [],
                familyConflictResolves: [],
                familyDisasters: []
            },
            errorHtml: "",
            errors: {},
            routes: window.appHelper.routes,
        };
    },
    methods: {
        getGROs() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            _this.j_gro_id = "";
            _this.j_sponsor_id = "";
            axios.post(_this.routes.init, {pid: this.j_project_id}).then((res) => {
                if (res.data) {
                    _this.initData.GROs = res.data.GROs;
                    _this.initData.sponsors = res.data.sponsors;
                } else {
                    _this.loading = false;
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                }
                _this.loading = false;
            });
        },
        mustahiqAdd(data) {
            this.formData.mustahiqs.push(data);
        },
        isEmpty(obj) {
            for (let key in obj) {
                if (obj.hasOwnProperty(key)) {
                    return false;
                }
            }
            return true;
        },
        objToString(obj) {
            for (let property in obj) {
                if (obj.hasOwnProperty(property)) {
                    this.errorHtml += `<p class='p-0 m-0'>${obj[property][0]}</p>`;
                }
            }
        },
        submit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    Swal.fire({
                        title: "Are you sure?",
                        html: `<p style="color:#40ae49">You want to submit this family</p>You won't be able to revert this!`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#40ae49",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Yes, submit it!",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            _this.onSubmit();
                        }
                    });
                }
            });
        },
        __appendArrayData(formData, rootKey, values) {
            let arrayKeys = ['vocational_haves', 'vocational_needs', 'skill_haves', 'skill_needs'];
            if (values.length > 0) {
                for (let i = 0; i < values.length; i++) {
                    let item = values[i];
                    for (let key in item) {
                        if (arrayKeys.includes(key)) {
                            this.__mustahiqArrayData(formData, rootKey, i, key, item[key]);
                        } else {
                            formData.append(`${rootKey}[${i}][${key}]`, item[key]);
                        }
                    }
                }
            }
        },
        __mustahiqArrayData(formData, rootKey, serial, childKey, values) {
            if (values.length > 0) {
                for (let i = 0; i < values.length; i++) {
                    let item = values[i];
                    for (let key in item) {
                        formData.append(`${rootKey}[${serial}][${childKey}][${i}]`, item[key]);
                    }
                }
            }
        },
        __newFormData() {
            let _this = this;
            let oldFormData = _this.formData;
            let arrayKeys = ["mustahiqs", "familyMembers", "familyAssets", "familyLoans", "familyIncomes", "familyExpenses", "familySavings", "familyOtherNgos", "familySafeties", "familyNeighborHelps", "familyRichHelps", "familyConflictResolves", "familyDisasters"];
            const formData = new FormData();
            for (let key in oldFormData) {
                if (oldFormData.hasOwnProperty(key)) {
                    if (arrayKeys.includes(key)) {
                        _this.__appendArrayData(formData, key, oldFormData[key]);
                    } else {
                        formData.append(key, oldFormData[key]);
                    }
                }
            }
            formData.append("j_project_id", _this.j_project_id);
            formData.append("j_gro_id", _this.j_gro_id);
            formData.append("j_sponsor_id", _this.j_sponsor_id);
            return formData;
        },
        onSubmit() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            _this.errorHtml = "";
            axios.post(_this.routes.one, _this.__newFormData()).then((res) => {
                if (res.data) {
                    toastr.success(res.data.success, "Success");
                    window.location.href = window.appHelper.routes.viewAll;
                } else {
                    _this.loading = false;
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.$setErrorsFromLaravel(err.response.data);
                    _this.errors = err.response.data.errors;
                    _this.objToString(_this.errors);
                }
                _this.loading = false;
            });
        },
        getInitData() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.post(_this.routes.init).then((res) => {
                if (res.data) {
                    _this.initData = res.data;
                } else {
                    _this.loading = false;
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err.response.data.message, "Error");
                if (err.response && err.response.data.errors) {
                    _this.errors = err.response.data.errors;
                }
                _this.loading = false;
            });
        },
    },
    created() {
        this.getInitData();
    }
};
</script>

<style scoped></style>

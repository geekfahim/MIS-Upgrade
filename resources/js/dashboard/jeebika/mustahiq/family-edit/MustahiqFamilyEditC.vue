<template>
    <div class="position-relative">
        <div v-if="!isEmpty(errors)" class="alert alert-danger alert-dismissible fade show" role="alert">
            <div v-html="errorHtml"></div>
            <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="row">
            <div class="col-md-12 mb-4">
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
                                Other NGO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="safety-tab" aria-controls="safety" aria-selected="true" class="nav-link"
                               data-toggle="tab"
                               href="#safety" role="tab">
                                Safety
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
                            <PersonalEditC></PersonalEditC>
                        </div>
                        <div id="family" aria-labelledby="family-tab" class="tab-pane fade" role="tabpanel">
                            <FamilyInfoEditC ref="FI"></FamilyInfoEditC>
                        </div>
                        <div id="family_asset" aria-labelledby="family-asset-tab" class="tab-pane fade" role="tabpanel">
                            <FamilyAssetEditC></FamilyAssetEditC>
                        </div>
                        <div id="family_income" aria-labelledby="family-income-tab" class="tab-pane fade"
                             role="tabpanel">
                            <FamilyIncomeEditC></FamilyIncomeEditC>
                        </div>
                        <div id="ngo" aria-labelledby="ngo-tab" class="tab-pane fade" role="tabpanel">
                            <NgoEditC></NgoEditC>
                        </div>
                        <div id="safety" aria-labelledby="safety-tab" class="tab-pane fade" role="tabpanel">
                            <SafetyEditC></SafetyEditC>
                        </div>
                        <div id="disaster" aria-labelledby="disaster-tab" class="tab-pane fade" role="tabpanel">
                            <DisasterEditC></DisasterEditC>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="loading" class="czm-loader">Loading&#8230;</div>
    </div>
</template>
<script>
import PersonalEditC from "./PersonalEditC";
import FamilyInfoEditC from "./FamilyInfoEditC";
import FamilyAssetEditC from "./FamilyAssetEditC";
import FamilyIncomeEditC from "./FamilyIncomeEditC";
import NgoEditC from "./NgoEditC";
import SafetyEditC from "./SafetyEditC";
import DisasterEditC from "./DisasterEditC";
import Select2 from "v-select2-component";

export default {
    name: "MustahiqFamilyEditC",
    components: {
        Select2,
        FamilyInfoEditC,
        PersonalEditC,
        FamilyAssetEditC,
        FamilyIncomeEditC,
        NgoEditC,
        SafetyEditC,
        DisasterEditC
    },
    props: {
        family: {
            required: true,
            type: Object
        }
    },
    inject: ["$validator"],
    data() {
        return {
            loading: false,
            initData: {
                groLists: [],
                sponsorLists: [],
                maritalStatuses: [],
                mustahiqLivingStatus: [],
                relationalLivingStatus: [],
                educationLevels: [],
                vocationalTrainings: [],
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
                //personal
                picture: "",
                mobile: "",
                alter_mobile: "",
                emergency_mobile: "",
                marital_status: "Unmarried",
                spouse_name: "",
                spouse_living_status: "",
                highest_education_level: "",
                is_vocational_training_ability: 'false',
                vocational_training_id: "",
                is_earn_ability: 'false',
                name: "",
                gender: "",
                pregnancy_status: "None",
                is_birth_date: "true",
                birth_date: "",
                age: "",
                is_orphan: 'false',
                orphan_type: "",
                religion: "",
                blood_group: "Unknown",
                email: "",
                nid: "",
                passport: "",
                birth_certificate: "",
                reference_number: "",
                father_name: "",
                father_living_status: "",
                mother_name: "",
                mother_living_status: "",
                is_family_head: "false",
                relation_with_family_head: "",
                occupation_id: "",
                monthly_income: "",
                remarks: "",
                is_disability: 'false',
                disability_id: "",
                is_disease: 'false',
                disease_id: "",
                is_disease_regular_medicine: 'false',
                present_address: "",
                present_district_id: "",
                present_upazila_id: "",
                present_union_id: "",
                present_thana: "",
                present_post_code: "",
                is_present_as_permanent: "true",
                permanent_address: "",
                permanent_district_id: "",
                permanent_union_id: "",
                permanent_upazila_id: "",
                permanent_post_code: "",

                // Family Info
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

                //others information
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
                familyDisasters: [],
            },
            picturePreview: "",
            errorHtml: "",
            errors: {},
            routes: window.appHelper.routes,
        };
    },
    methods: {
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
                    this.errorHtml += "<p class='p-0 m-0'>" + obj[property][0] + "</p>";
                }
            }
        },
        submit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.onSubmit();
                }
            });
        },
        _appendArrayData(formData, key, values) {
            if (values.length > 0) {
                for (let i = 0; i < values.length; i++) {
                    let item = values[i];
                    for (let row in item) {
                        let v = values[i][row];
                        formData.append(key + "[" + i + "][" + row + "]", v);
                    }
                }
            }
        },
        _newFromData() {
            let _this = this;
            let oldFormData = _this.formData;
            let keys = ["familyMembers", "familyAssets", "familyLoans", "familyIncomes", "familyExpenses", "familySavings", "familyOtherNgos", "familySafeties", "familyNeighborHelps", "familyRichHelps", "familyConflictResolves", "familyDisasters",
            ];
            const formData = new FormData();
            for (let key in oldFormData) {
                if (oldFormData.hasOwnProperty(key)) {
                    if (keys.indexOf(key) >= 0) {
                        _this._appendArrayData(formData, key, oldFormData[key]);
                    } else {
                        formData.append(key, oldFormData[key]);
                    }
                }
            }
            return formData;
        },
        onSubmit() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            _this.errorHtml = "";
            axios.post(_this.routes.one, _this._newFromData()).then((res) => {
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
    },
    mounted() {
        let _this = this;
        $(".datepicker")
            .datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                startDate: "-200y",
                autoclose: true,
            })
            .on("changeDate", (event) => {
                let value = event.currentTarget.value;
                switch (event.currentTarget.name) {
                    case "birth_date":
                        _this.formData.birth_date = value;
                        break;
                }
            });
    },
};
</script>

<style scoped></style>

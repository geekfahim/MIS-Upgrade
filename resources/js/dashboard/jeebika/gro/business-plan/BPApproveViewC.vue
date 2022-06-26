<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Business Plan Approve
            <div class="card-header-actions">
                <span class="badge badge-warning" v-if="'Pending'===bp.status">Pending</span>
                <span class="badge badge-info" v-else-if="'Hold'===bp.status">Hold</span>
                <span class="badge badge-primary" v-else-if="'Approved'===bp.status">Approved</span>
                <span class="badge badge-success" v-else-if="'Ongoing'===bp.status">Ongoing</span>
                <span class="badge badge-secondary" v-else-if="'Completed'===bp.status">Completed</span>
                <span class="badge badge-danger" v-else-if="'Rejected'===bp.status">Rejected</span>
                <span class="text-capitalize" v-else>{{ bp.status }}</span>
            </div>
        </div>
        <div class="card-body">
            <!-- If Status Pending/Hold -->
            <div v-if="isStatusPendingOrHold">
                <div v-if="!isEmpty(errors)" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div v-html="errorHtml"></div>
                    <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form class="form-horizontal" v-on:submit.prevent="onSubmit">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="d-block">Valid Information<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_valid_information_true"
                                           v-model="formData.is_valid_information"
                                           class="form-check-input" name="is_valid_information"
                                           type="radio" value="true"/>
                                    <label class="form-check-label"
                                           for="is_valid_information_true">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_valid_information_false"
                                           v-model="formData.is_valid_information"
                                           class="form-check-input" name="is_valid_information"
                                           type="radio" value="false"/>
                                    <label class="form-check-label"
                                           for="is_valid_information_false">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="d-block">Previous Installment<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_previous_installment_true"
                                           v-model="formData.is_previous_installment"
                                           class="form-check-input" name="is_previous_installment"
                                           type="radio" value="true"/>
                                    <label class="form-check-label"
                                           for="is_previous_installment_true">Regular</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_previous_installment_false"
                                           v-model="formData.is_previous_installment"
                                           class="form-check-input" name="is_previous_installment"
                                           type="radio" value="false"/>
                                    <label class="form-check-label"
                                           for="is_previous_installment_false">Irregular</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="d-block">Business Experience and Skill<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_proposed_business_skill_and_experience_true"
                                           v-model="formData.is_proposed_business_skill_and_experience"
                                           class="form-check-input"
                                           name="is_proposed_business_skill_and_experience"
                                           type="radio" value="true"/>
                                    <label class="form-check-label"
                                           for="is_proposed_business_skill_and_experience_true">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_proposed_business_skill_and_experience_false"
                                           v-model="formData.is_proposed_business_skill_and_experience"
                                           class="form-check-input"
                                           name="is_proposed_business_skill_and_experience"
                                           type="radio" value="false"/>
                                    <label class="form-check-label"
                                           for="is_proposed_business_skill_and_experience_false">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="d-block">General Savings<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_general_savings_true"
                                           v-model="formData.is_general_savings"
                                           class="form-check-input" name="is_general_savings"
                                           type="radio" value="true"/>
                                    <label class="form-check-label"
                                           for="is_general_savings_true">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_general_savings_false"
                                           v-model="formData.is_general_savings"
                                           class="form-check-input" name="is_general_savings"
                                           type="radio" value="false"/>
                                    <label class="form-check-label"
                                           for="is_general_savings_false">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="d-block">Recommend for Investment<span
                                    class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input id="is_recommended_true"
                                           v-model="formData.is_recommended"
                                           class="form-check-input" name="is_recommended"
                                           type="radio" value="true"/>
                                    <label class="form-check-label"
                                           for="is_recommended_true">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input id="is_recommended_false"
                                           v-model="formData.is_recommended"
                                           class="form-check-input" name="is_recommended"
                                           type="radio" value="false"/>
                                    <label class="form-check-label"
                                           for="is_recommended_false">No</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">Recommendation Remarks</label>
                                <div class="input-group input-group-sm">
                                                        <textarea placeholder="recommendation remarks"
                                                                  data-vv-name="recommendation_remarks"
                                                                  v-validate="'max:100'" class="form-control rounded-0"
                                                                  rows="2"
                                                                  v-model="formData.recommendation_remarks"></textarea>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('recommendation_remarks')">
                                        {{ vvErrors.first("recommendation_remarks") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">GRO Meeting Date<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input placeholder="date: yyyy-mm-dd" id="meeting_date"
                                           name="meeting_date" type="text"
                                           data-vv-name="meeting_date" data-vv-as="meeting date"
                                           :class="[this.vvErrors.has('meeting_date') ? 'is-invalid' : '']"
                                           v-validate="'required|date_format:yyyy-mm-dd'"
                                           class="form-control form-control-sm rounded-0 datepicker"
                                           v-model="formData.meeting_date" autocomplete="off"/>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('meeting_date')">
                                        {{ vvErrors.first("meeting_date") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">GRO Meeting Decision<span
                                    class="text-danger">*</span></label>
                                <select class="form-control form-control-sm"
                                        v-model.number="formData.meeting_status" data-vv-name="meeting_status"
                                        data-vv-as="GRO Decision" v-validate="'required'"
                                        :class="[(vvErrors.has('meeting_status') ? 'is-invalid' : '')]">
                                    <option value="">Select One</option>
                                    <option v-for="item in bp.meetingStatuses" :key="item" :value="item">
                                        {{ item }}
                                    </option>
                                </select>
                                <div class="invalid-feedback" v-show="vvErrors.has('meeting_status')">
                                    {{ vvErrors.first('meeting_status') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="'Approved'===formData.meeting_status">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">Approved Amount<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input data-vv-name="approved_amount"
                                           data-vv-as="approved amount"
                                           v-validate="'required|min:2|max:11|numeric'"
                                           :class="[vvErrors.has('approved_amount') ? 'is-invalid' : '']"
                                           class="form-control form-control-sm rounded-0"
                                           placeholder="approved amount" type="number"
                                           v-model.number="formData.approved_amount"/>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('approved_amount')">
                                        {{ vvErrors.first("approved_amount") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">Disbursement Date<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input placeholder="date: yyyy-mm-dd" id="disbursement_date"
                                           name="disbursement_date" type="text"
                                           data-vv-name="disbursement_date"
                                           data-vv-as="disbursement date"
                                           :class="[this.vvErrors.has('disbursement_date') ? 'is-invalid' : '']"
                                           v-validate="'required|date_format:yyyy-mm-dd'"
                                           class="form-control form-control-sm rounded-0 datepicker"
                                           v-model="formData.disbursement_date" autocomplete="off"/>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('disbursement_date')">
                                        {{ vvErrors.first("disbursement_date") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">Disbursement Amount<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <input data-vv-name="disbursement_amount"
                                           data-vv-as="disbursement amount"
                                           v-validate="'required|min:2|max:11|numeric'"
                                           :class="[vvErrors.has('disbursement_amount') ? 'is-invalid' : '']"
                                           class="form-control form-control-sm rounded-0"
                                           placeholder="disbursment amount" type="number"
                                           v-model.number="formData.disbursement_amount"/>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('disbursement_amount')">
                                        {{ vvErrors.first("disbursement_amount") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">Investment Area<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <select class="form-control form-control-sm"
                                            v-model="formData.approved_investment_area_id"
                                            data-vv-name="approved_investment_area_id"
                                            data-vv-as="approved investment area"
                                            v-validate="'required'"
                                            :class="[(vvErrors.has('approved_investment_area_id') ? 'is-invalid' : '')]">
                                        <option value="">Select One</option>
                                        <option v-for="item in bp.investmentAreas" :key="item.id"
                                                :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('approved_investment_area_id')">
                                        {{ vvErrors.first('approved_investment_area_id') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="czm-xs">Terms of Return<span
                                    class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <select v-model="formData.approved_investment_return_type"
                                            data-vv-name="approved_investment_return_type"
                                            data-vv-as="terms of return" v-validate="'required'"
                                            data-vv-validate-on="change"
                                            :class="[vvErrors.has('approved_investment_return_type') ? 'is-invalid' : '']"
                                            class="form-control form-control-sm rounded-0">
                                        <option value="">Select One</option>
                                        <option v-for="item in bp.investmentReturnTypes" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div class="invalid-feedback"
                                         v-show="vvErrors.has('approved_investment_return_type')">
                                        {{ vvErrors.first("approved_investment_return_type") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="czm-xs">Resolution</label>
                            <div class="border border-secondary p-1">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input type="file" id="file" name="file" ref="file"
                                               accept="image/jpeg,image/jpg,image/png,application/pdf"
                                               @change="fileUpload($event)"/>
                                        <div class="invalid-feedback" v-show="vvErrors.has('file')">
                                            {{ vvErrors.first("file") }}
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <input data-vv-name="file_remarks" data-vv-as="resolution remarks"
                                               v-validate="'name_with_number|min:2|max:50'"
                                               :class="[vvErrors.has('file_remarks') ? 'is-invalid' : '']"
                                               class="form-control form-control-sm rounded-0"
                                               placeholder="resolution remarks"
                                               type="text" v-model="formData.file_remarks"/>
                                        <div class="invalid-feedback" v-show="vvErrors.has('file_remarks')">
                                            {{ vvErrors.first("file_remarks") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="form-group">
                                    <label class="czm-xs">Resolution Processed By<span
                                        class="text-danger">*</span></label>
                                    <Select2 data-vv-name="resolution_processed_by" data-vv-as="Resolution Processed By"
                                             v-validate="'required'" data-vv-validate-on="change"
                                             v-model.number="formData.resolution_processed_by" :options="bp.gro_heads"
                                             :settings="{ width: '100%', allowClear: true }"/>
                                    <div class="invalid-feedback"
                                         :class="[(vvErrors.has('resolution_processed_by') ? ' d-block' : '')]"
                                         v-if="vvErrors.has('resolution_processed_by')">
                                        {{ vvErrors.first('resolution_processed_by') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- GRO Remarks -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="czm-xs">Gro Remarks</label>
                                <div class="input-group input-group-sm">
                                                    <textarea placeholder="type here.." data-vv-name="gro_remarks"
                                                              v-validate="'name_with_number|max:100'"
                                                              class="form-control rounded-0"
                                                              rows="2" v-model="formData.gro_remarks"></textarea>
                                    <div class="invalid-feedback" v-show="vvErrors.has('gro_remarks')">
                                        {{ vvErrors.first("gro_remarks") }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="btn btn-sm btn-primary rounded-0 m-5"
                                        type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- If Status Approved/Verified/Ongoing/Completed/Rejected -->
            <div v-else>
                <table class="table table-sm table-borderless">
                    <tbody>
                    <tr>
                        <td>Recommended Investment:
                            <span v-if="bp.is_recommended"
                                  class="badge badge-md badge-success">Yes</span>
                            <span class="badge badge-md badge-danger" v-else>No</span>
                        </td>
                        <td>Valid Information:
                            <span v-if="bp.is_valid_information"
                                  class="badge badge-md badge-success">Yes</span>
                            <span class="badge badge-md badge-danger" v-else>No</span>
                        </td>
                        <td>Previous Installment:
                            <span v-if="bp.is_previous_installment"
                                  class="badge badge-md badge-success">Yes</span>
                            <span class="badge badge-md badge-danger" v-else>No</span>
                        </td>
                        <td>Experience and Skill:
                            <span v-if="bp.is_proposed_business_skill_and_experience"
                                  class="badge badge-md badge-success">Yes</span>
                            <span class="badge badge-md badge-danger" v-else>No</span>
                        </td>
                        <td>General Saving:
                            <span v-if="bp.is_general_savings"
                                  class="badge badge-md badge-success">Yes</span>
                            <span class="badge badge-md badge-danger" v-else>No</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">Recommendation Remarks: <b>{{ bp.recommendation_remarks }}</b></td>
                    </tr>
                    <tr>
                        <td v-if="bp.is_business_experience">Business Experience Duration:
                            <b>{{ bp.business_experience_duration }} Month</b>
                        </td>
                        <td v-if="bp.is_business_training">Training Duration:
                            <b>{{ bp.business_training_duration }} Month</b>
                        </td>
                        <td v-if="bp.is_business_training" colspan="3">Training Institute Name:
                            <b>{{ bp.business_training_institute_name }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Gro Meeting Date: <b>{{ bp.meeting_date | dateFormat }}</b></td>
                        <td>Gro Meeting Decision:
                            <span class="badge badge-warning" v-if="'Pending'===bp.meeting_status">Pending</span>
                            <span class="badge badge-info" v-else-if="'Hold'===bp.meeting_status">Hold</span>
                            <span class="badge badge-primary" v-else-if="'Approved'===bp.meeting_status">Approved</span>
                            <span class="badge badge-danger" v-else-if="'Rejected'===bp.meeting_status">Rejected</span>
                            <span class="text-capitalize" v-else>{{ bp.meeting_status }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5">Gro Remarks: <b>{{ bp.gro_remarks }}</b></td>
                    </tr>
                    <tr>
                        <td v-if="bp.approved_amount">Approved Amount: <b>{{ bp.approved_amount }}</b></td>
                        <td v-if="bp.disbursement_amount">Disbursement Amount: <b>{{ bp.disbursement_amount }}</b></td>
                        <td v-if="bp.disbursement_date">Disbursement Date:
                            <b>{{ bp.disbursement_date | dateFormat }}</b></td>
                        <td v-if="bp.j_investment_approved_area">Approved Investment Area:
                            <b>{{ bp.j_investment_approved_area.name }}</b>
                        </td>
                        <td v-if="bp.approved_investment_return_type">Approved Investment Return Type:
                            <b>{{ bp.approved_investment_return_type }}</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Resolution Processed By:
                            <b>{{ bp.resolution_processed_by ? bp.resolution_processed_by.name : '' }}</b>
                        </td>
                        <td colspan="5">Resolution:
                            <span v-if="bp.resource">
                                <span v-if="bp.resource.remarks">({{ bp.resource.remarks }}) </span>
                                <a target="_blank" type="button"
                                   class="btn btn-xs btn-spotify mx-2"
                                   :href="bp.resource.path" :download="bp.resource.name">
                                    <i class="fa fa-arrow-circle-down"></i><span>&nbsp;Download</span>
                                </a>
                            </span>
                            <button class="btn btn-xs btn-danger mx-2" v-else>No File</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="czm-loader" v-if="loading">Loading&#8230;</div>
    </div>
</template>

<script>
import Select2 from "v-select2-component";
import Pagination from "../../../Pagination";

export default {
    name: "BPApproveViewC",
    components: {Pagination, Select2},
    props: {
        bp: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            isStatusPendingOrHold: false,
            loading: false,
            formView: false,
            errorHtml: "",
            errors: {},
            fileExist: false,
            isFileAdded: false,
            formData: {
                is_valid_information: false,
                is_previous_installment: false,
                is_proposed_business_skill_and_experience: false,
                is_general_savings: false,
                is_recommended: false,
                recommendation_remarks: "",
                meeting_date: "",
                meeting_status: "",
                gro_remarks: "",
                //if Approve
                approved_amount: "",
                resolution_processed_by: "",
                file: "",
                file_remarks: "",
                disbursement_date: "",
                disbursement_amount: "",
                approved_investment_area_id: "",
                approved_investment_return_type: ""
            },
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
        fileUpload(e) {
            let _this = this;
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            if (/\.(jpeg|jpg|png|pdf)$/i.test(files[0].name)) {
                if (files[0].size < 202400) {
                    _this.isFileAdded = true;
                    _this.formData.file = files[0];
                } else {
                    Swal.fire("Invalid file size!", "max-size:100kb", "warning");
                    _this.formData.file = {};
                    _this.$refs.file.value = null;
                }
            } else {
                Swal.fire(
                    "Invalid file type!",
                    "Select in - jpeg,jpg,png,pdf",
                    "warning"
                );
                _this.formData.file = {};
                _this.$refs.file.value = null;
            }
        },
        onSubmit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.onNewAdd();
                }
            });
        },
        _newFormData() {
            let _this = this;
            let oldFormData = _this.formData;
            const formData = new FormData();
            for (let key in oldFormData) {
                if (oldFormData.hasOwnProperty(key)) {
                    formData.append(key, oldFormData[key]);
                }
            }
            return formData;
        },
        onNewAdd() {
            let _this = this;
            _this.loading = true;
            _this.errors = _this.errorHtml = '';
            axios.post(_this.routes.one, _this._newFormData()).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    setTimeout(function () {
                        window.location.href = _this.routes.one;
                    }, 500);
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.errors = error.response.data.errors;
                        _this.objToString(_this.errors);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
    },
    created() {
        this.formData.id = this.bp.id;
        if (['Pending', 'Hold'].includes(this.bp.status)) {
            this.isStatusPendingOrHold = true;
            this.formData.is_valid_information = this.bp.is_valid_information;
            this.formData.is_previous_installment = this.bp.is_previous_installment;
            this.formData.is_proposed_business_skill_and_experience = this.bp.is_proposed_business_skill_and_experience;
            this.formData.is_general_savings = this.bp.is_general_savings;
            this.formData.is_recommended = this.bp.is_recommended;
            this.formData.recommendation_remarks = this.bp.recommendation_remarks ?? '';
            this.formData.meeting_date = this.bp.meeting_date;
            $("#meeting_date").datepicker("update", this.formData.meeting_date);
            this.formData.meeting_status = this.bp.meeting_status;
            this.formData.gro_remarks = this.bp.gro_remarks ?? '';
        }
    },
    updated() {
        this.$nextTick(() => {
            $(".datepicker").datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                startDate: "-200y",
                autoclose: true,
            }).on("changeDate", (event) => {
                let value = event.currentTarget.value;
                switch (event.currentTarget.name) {
                    case "disbursement_date":
                        this.formData.disbursement_date = value;
                        break;
                    case "meeting_date":
                        this.formData.meeting_date = value;
                        break;
                }
            });
        });
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        }
    }
};
</script>

<style scoped>
</style>

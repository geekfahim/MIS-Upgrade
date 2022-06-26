<template>
    <div>
        <!-- Assets -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #4dbd74;font-size: 1.09375rem">Assets
                    <button class="btn btn-brand btn-success btn-sm pull-right" @click="addNewAsset">
                        <i class="fa fa-plus"></i>
                        <span>Add New Asset</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Location</th>
                    <th>Value</th>
                    <th>Remarks</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in assets" :key=index>
                    <td>{{ item.asset ? item.asset.name : '' }}</td>
                    <td>{{ item.asset_quantity }}</td>
                    <td>{{ item.asset_location }}</td>
                    <td>{{ item.asset_value }}</td>
                    <td>{{ item.asset_remarks }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editAsset(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteAsset(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="assets.length === 0">
                    <td class="text-center" colspan="6">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Asset Create/Edit Modal -->
        <div id="assetCreateEditModal" aria-hidden="true" aria-labelledby="Asset Modal" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="assetScope"
                              v-on:submit.prevent="submitAsset('assetScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Asset</strong>
                                    <strong v-else>Update Asset</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Asset<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="assetFormData.asset_id" v-validate="'required'"
                                            :class="[(vvErrors.has('assetScope.asset_id') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="asset"
                                            data-vv-name="asset_id">
                                        <option value="">Select One</option>
                                        <option v-for="item in $parent.initData.assets" :key="item.id" :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('assetScope.asset_id')" class="invalid-feedback">
                                        {{ vvErrors.first('assetScope.asset_id') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Quantity / Size</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="assetFormData.asset_quantity"
                                           v-validate="'name_with_number|max:50'"
                                           :class="[(vvErrors.has('assetScope.asset_quantity') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="quantity or size" data-vv-name="asset_quantity"
                                           type="text">
                                    <div v-show="vvErrors.has('assetScope.asset_quantity')" class="invalid-feedback">
                                        {{ vvErrors.first('assetScope.asset_quantity') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Location</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="assetFormData.asset_location"
                                           v-validate="'name_with_number|max:50'"
                                           :class="[(vvErrors.has('assetScope.asset_location') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="location" data-vv-name="asset_location"
                                           type="text">
                                    <div v-show="vvErrors.has('assetScope.asset_location')" class="invalid-feedback">
                                        {{ vvErrors.first('assetScope.asset_location') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Value(approx)<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model.number="assetFormData.asset_value"
                                           v-validate="'required|numeric|max_value:10000000'"
                                           :class="[(vvErrors.has('assetScope.asset_value') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="value" data-vv-name="asset_value" type="text">
                                    <div v-show="vvErrors.has('assetScope.asset_value')" class="invalid-feedback">
                                        {{ vvErrors.first('assetScope.asset_value') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <textarea v-model="assetFormData.asset_remarks" v-validate="'name_with_number|max:900'"
                                          :class="[(vvErrors.has('assetScope.asset_remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4"
                                          data-vv-as="remarks" data-vv-name="asset_remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('assetScope.asset_remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('assetScope.asset_remarks') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <button aria-label="Close" class="btn btn-sm btn-danger pull-left rounded-0"
                                        data-dismiss="modal" type="button">
                                    <span aria-hidden="true">Close</span>
                                </button>
                                <button v-if="createView" class="btn btn-sm btn-primary pull-right rounded-0"
                                        type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Submit
                                </button>
                                <button v-else class="btn btn-sm btn-primary pull-right rounded-0" type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Loans -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #63c2de;font-size: 1.09375rem">Loans
                    <button class="btn btn-brand btn-info btn-sm pull-right" @click="addNewLoan">
                        <i class="fa fa-plus"></i>
                        <span>Add New loans</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Source Type</th>
                    <th>Source Name</th>
                    <th>Taking Date</th>
                    <th>Amount</th>
                    <th>Duration</th>
                    <th>Purpose</th>
                    <th>Outstanding Amount</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in loans" :key=index>
                    <td>{{ item.loan_source }}</td>
                    <td>{{ item.loan_source_name }}</td>
                    <td>{{ item.loan_taking_date | dateFormat }}</td>
                    <td>{{ item.loan_amount }}</td>
                    <td>{{ item.loan_duration }}</td>
                    <td>{{ item.loan_purpose }}</td>
                    <td>{{ item.loan_outstanding_amount }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editLoan(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteLoan(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="loans.length === 0">
                    <td class="text-center" colspan="8">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Loan Create/Edit Modal -->
        <div id="loanCreateEditModal" aria-hidden="true" aria-labelledby="Loan Modal" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="loanScope"
                              v-on:submit.prevent="submitLoan('loanScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Loan</strong>
                                    <strong v-else>Update Asset</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Source of Loan<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="loanFormData.loan_source" v-validate="'required'"
                                            :class="[(vvErrors.has('loanScope.loan_source') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0" data-vv-as="source"
                                            data-vv-name="loan_source" data-vv-validate-on="change">
                                        <option value="">Select One</option>
                                        <option v-for="item in SOURCE_TYPES" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('loanScope.loan_source')" class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_source') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Loan Source Name<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="loanFormData.loan_source_name"
                                           v-validate="'required|name_with_number|max:50'"
                                           :class="[(vvErrors.has('loanScope.loan_source_name') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="loan source name" data-vv-name="loan_source_name"

                                           type="text">
                                    <div v-show="vvErrors.has('loanScope.loan_source_name')" class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_source_name') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Loan Taking Date<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input id="loan_taking_date"
                                           v-validate="'required|date_format:yyyy-mm-dd|max:10'"
                                           :class="[(vvErrors.has('loanScope.loan_taking_date') ? 'is-invalid' : '')]"
                                           autocomplete="off"
                                           class="form-control form-control-sm rounded-0 loan-datepicker"
                                           data-vv-as="Date of Talking Loan"
                                           data-vv-name="loan_taking_date" name="loan_taking_date" type="text">
                                    <div v-show="vvErrors.has('loanScope.loan_taking_date')" class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_taking_date') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Amount<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model.number="loanFormData.loan_amount"
                                           v-validate="'required|numeric|max_value:10000000'"
                                           :class="[(vvErrors.has('loanScope.loan_amount') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0" data-vv-as="amount"
                                           data-vv-name="loan_amount" type="text">
                                    <div v-show="vvErrors.has('loanScope.loan_amount')" class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_amount') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Rate / Extra Amount</label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model.number="loanFormData.loan_rate_or_extra_amount"
                                           v-validate="'numeric|max:10'"
                                           :class="[(vvErrors.has('loanScope.loan_rate_or_extra_amount') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="rate or extra amount" data-vv-name="loan_rate_or_extra_amount"
                                           type="text">
                                    <div v-show="vvErrors.has('loanScope.loan_rate_or_extra_amount')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_rate_or_extra_amount') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Duration<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model="loanFormData.loan_duration"
                                           v-validate="'required|name_with_number|max:20'"
                                           :class="[(vvErrors.has('loanScope.loan_duration') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="loan duration" data-vv-name="loan_duration" type="text">
                                    <div v-show="vvErrors.has('loanScope.loan_duration')" class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_duration') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Loan Purpose<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="loanFormData.loan_purpose" v-validate="'required'"
                                            :class="[(vvErrors.has('loanScope.loan_purpose') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0" data-vv-as="purpose"
                                            data-vv-name="loan_purpose">
                                        <option value="">Select One</option>
                                        <option v-for="item in PURPOSE_TYPES" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('loanScope.loan_purpose')" class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_purpose') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Outstanding Amount<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-file-text-o"></i>
                                        </span>
                                    </div>
                                    <input v-model.number="loanFormData.loan_outstanding_amount"
                                           v-validate="'required|numeric|max_value:10000000'"
                                           :class="[(vvErrors.has('loanScope.loan_outstanding_amount') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="outstanding amount" data-vv-name="loan_outstanding_amount"
                                           type="text">
                                    <div v-show="vvErrors.has('loanScope.loan_outstanding_amount')"
                                         class="invalid-feedback">
                                        {{ vvErrors.first('loanScope.loan_outstanding_amount') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <textarea v-model="loanFormData.loan_remarks" v-validate="'name_with_number|max:900'"
                                          :class="[(vvErrors.has('loanScope.loan_remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4" data-vv-as="remarks" data-vv-name="loan_remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('loanScope.loan_remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('loanScope.loan_remarks') }}
                                </div>
                            </div>
                            <div class="form-group">
                                <button aria-label="Close" class="btn btn-sm btn-danger pull-left rounded-0"
                                        data-dismiss="modal" type="button">
                                    <span aria-hidden="true">Close</span>
                                </button>
                                <button v-if="createView" class="btn btn-sm btn-primary pull-right rounded-0"
                                        type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Submit
                                </button>
                                <button v-else class="btn btn-sm btn-primary pull-right rounded-0" type="submit">
                                    <i class="fa fa-dot-circle-o"></i>
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FamilyAssetEditC",
    data() {
        return {
            //common
            createView: true,
            //Asset
            asset_types: [],
            assets: [],
            assetFormData: {
                id: '',
                asset_id: '',
                asset_quantity: '',
                asset_location: '',
                asset_value: '',
                asset_remarks: ''
            },
            //Loan
            loans: [],
            SOURCE_TYPES: [],
            PURPOSE_TYPES: [],
            loanFormData: {
                id: '',
                loan_source: '',
                loan_source_name: '',
                loan_taking_date: '',
                loan_amount: '',
                loan_rate_or_extra_amount: '',
                loan_duration: '',
                loan_purpose: '',
                loan_outstanding_amount: '',
                loan_remarks: '',
            }
        }
    },
    methods: {
        /* Loan */
        editLoan(item) {
            this.createView = false;
            this.loanFormData = {};
            this.loanFormData.id = item.id;
            this.loanFormData.loan_source = item.loan_source;
            this.loanFormData.loan_source_name = item.loan_source_name;
            this.loanFormData.loan_taking_date = item.loan_taking_date;
            $("#loan_taking_date").datepicker("update", this.loanFormData.loan_taking_date);
            this.loanFormData.loan_amount = item.loan_amount;
            this.loanFormData.loan_rate_or_extra_amount = item.loan_rate_or_extra_amount;
            this.loanFormData.loan_duration = item.loan_duration;
            this.loanFormData.loan_purpose = item.loan_purpose;
            this.loanFormData.loan_outstanding_amount = item.loan_outstanding_amount;
            this.loanFormData.loan_remarks = item.loan_remarks;
            this.$validator.reset();
            $("#loanCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteLoan(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.loan_source_name}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.loan + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllLoans();
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
                }
            });
        },
        submitLoan(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addLoan();
                } else if (result && !_this.createView) {
                    _this._updateLoan();
                }
            });
        },
        _addLoan() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.loan, _this.loanFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllLoans();
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
        _updateLoan() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.loan + "/" + _this.loanFormData.id, _this.loanFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllLoans();
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
        addNewLoan() {
            this.createView = true;
            this.loanFormData = {};
            this.loanFormData.loan_source = "";
            this.loanFormData.loan_source_name = "";
            this.loanFormData.loan_taking_date = "";
            $("#loan_taking_date").datepicker("update", "");
            this.loanFormData.loan_amount = "";
            this.loanFormData.loan_rate_or_extra_amount = "";
            this.loanFormData.loan_duration = "";
            this.loanFormData.loan_purpose = "";
            this.loanFormData.loan_outstanding_amount = "";
            this.loanFormData.loan_remarks = "";
            this.$validator.reset();
            $("#loanCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllLoans() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            axios.get(this.$parent.routes.loan).then((res) => {
                if (res.data) {
                    _this.loans = res.data.lists;
                    _this.SOURCE_TYPES = res.data.SOURCE_TYPES;
                    _this.PURPOSE_TYPES = res.data.PURPOSE_TYPES;
                    $('#loanCreateEditModal').modal('hide');
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
        /* Asset */
        editAsset(item) {
            this.createView = false;
            this.assetFormData = {};
            this.assetFormData.id = item.id;
            this.assetFormData.asset_id = item.asset_id;
            this.assetFormData.asset_quantity = item.asset_quantity;
            this.assetFormData.asset_location = item.asset_location;
            this.assetFormData.asset_value = item.asset_value;
            this.assetFormData.asset_remarks = item.asset_remarks;
            this.$validator.reset();
            $("#assetCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteAsset(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.asset ? item.asset.name : ''}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.asset + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllAssets();
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
                }
            });
        },
        submitAsset(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addAsset();
                } else if (result && !_this.createView) {
                    _this._updateAsset();
                }
            });
        },
        _addAsset() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.asset, _this.assetFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllAssets();
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
        _updateAsset() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.asset + "/" + _this.assetFormData.id, _this.assetFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllAssets();
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
        addNewAsset() {
            this.createView = true;
            this.assetFormData = {};
            this.assetFormData.asset_id = "";
            this.assetFormData.asset_quantity = "";
            this.assetFormData.asset_location = "";
            this.assetFormData.asset_value = "";
            this.assetFormData.asset_remarks = "";
            this.$validator.reset();
            $("#assetCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllAssets() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.assetFormData = {};
            axios.get(this.$parent.routes.asset).then((res) => {
                if (res.data) {
                    _this.assets = res.data.lists;
                    _this.asset_types = res.data.asset_types;
                    $('#assetCreateEditModal').modal('hide');
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
        this.getAllAssets();
        this.getAllLoans();
    },
    mounted() {
        let _this = this;
        $(".loan-datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-200y",
            autoclose: true,
        }).on("changeDate", (event) => {
            let value = event.currentTarget.value;
            switch (event.currentTarget.name) {
                case "loan_taking_date":
                    _this.loanFormData.loan_taking_date = value;
                    break;
            }
        });
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        }
    }
}
</script>

<style scoped>

</style>

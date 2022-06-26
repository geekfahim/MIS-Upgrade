<template>
    <div class="container">
        <!-- Asset -->
        <div class="row">
            <div class="card w-100">
                <div class="card-header d-flex justify-content-between">
                    <h5>Asset</h5>
                    <div class="text-danger">
                        <span>Total Value: {{ totalAsset }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div v-if="$parent.formData.familyAssets.length > 0" class="form-group">
                            <div class="table-responsive">
                                <table class="table table-sm table-stripe">
                                    <thead class="bg-gray-100">
                                    <tr>
                                        <th>Asset Type</th>
                                        <th>Quantity</th>
                                        <th>Location</th>
                                        <th>Value</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item,index) of $parent.formData.familyAssets" :key="index">
                                        <td>{{ getAssetName(item.asset_id) }}</td>
                                        <td>{{ item.asset_quantity }}</td>
                                        <td>{{ item.asset_location }}</td>
                                        <td>{{ item.asset_value }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-danger rounded-0"
                                                    @click="requestRemoveFamilyAsset(item.asset_id,index)">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <small class="text-danger">
                                    * {{ maxCount - $parent.formData.familyAssets.length }} Family Asset remaining!
                                </small>
                            </div>
                        </div>
                    </div>
                    <div v-if="maxCount != $parent.formData.familyAssets.length" class="col-lg-12 col-md-12 col-sm-12">
                        <form data-vv-scope="a_v" @submit.prevent="onAssetSubmit('a_v')">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Asset Type<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <select v-model="assetData.asset_id" v-validate="'required'"
                                                    :class="[(vvErrors.has('a_v.asset_id') ? 'is-invalid' : '')]"
                                                    class="form-control form-control-sm rounded-0"
                                                    data-vv-as="asset type" data-vv-name="asset_id">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in $parent.initData.assets" :key="index"
                                                        :value="item.id">
                                                    {{ item.name | textCapitalize }}
                                                </option>
                                            </select>
                                            <div v-if="vvErrors.has('a_v.asset_id')" class="invalid-feedback">
                                                {{ vvErrors.first('a_v.asset_id') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Quantity / Size</label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="assetData.asset_quantity"
                                                   v-validate="'name_with_number|max:10'"
                                                   :class="[(vvErrors.has('a_v.asset_quantity') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="asset quantity or size" data-vv-name="asset_quantity"
                                                   type="text">
                                            <div v-if="vvErrors.has('a_v.asset_quantity')" class="invalid-feedback">
                                                {{ vvErrors.first('a_v.asset_quantity') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Location</label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="assetData.asset_location" v-validate="'alpha_dash|max:30'"
                                                   :class="[(vvErrors.has('a_v.asset_location') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="asset location" data-vv-name="asset_location"
                                                   type="text">
                                            <div v-if="vvErrors.has('a_v.asset_location')" class="invalid-feedback">
                                                {{ vvErrors.first('a_v.asset_location') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Value(approx)<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="assetData.asset_value"
                                                   v-validate="'required|numeric|max:150'"
                                                   :class="[(vvErrors.has('a_v.asset_value') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="asset value" data-vv-name="asset_value" type="text">
                                            <div v-if="vvErrors.has('a_v.asset_value')" class="invalid-feedback">
                                                {{ vvErrors.first('a_v.asset_value') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-inline-block mt-3">
                                <button class="btn btn-brand btn-sm btn-czm-green pull-left" style="margin-bottom: 4px"
                                        type="submit">
                                    <i class="fa fa-plus"></i>
                                    <span>Add Asset</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Loan -->
        <div class="row">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5>Liabilities/Loans</h5>
                    <div class="text-danger">
                        <span>Total Outstanding Amount: {{ totalLoan }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div v-if="$parent.formData.familyLoans.length > 0" class="form-group">
                            <div class="table-responsive">
                                <table class="table table-sm table-stripe">
                                    <thead class="bg-gray-100">
                                    <tr>
                                        <th>Loan Source</th>
                                        <th>Source Name</th>
                                        <th>Date of Taking</th>
                                        <th>Amount</th>
                                        <th>Rate/E.Amount</th>
                                        <th>Duration</th>
                                        <th>Purpose</th>
                                        <th>Outstanding Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(item,index) in $parent.formData.familyLoans" :key="index">
                                        <td>{{ item.loan_source }}</td>
                                        <td>{{ item.loan_source_name }}</td>
                                        <td>{{ item.loan_taking_date | dateFormat }}</td>
                                        <td>{{ item.loan_amount }}</td>
                                        <td>{{ item.loan_rate_or_extra_amount }}</td>
                                        <td>{{ item.loan_duration }}</td>
                                        <td>{{ item.loan_purpose }}</td>
                                        <td>{{ item.loan_outstanding_amount }}</td>
                                        <td>
                                            <button class="btn btn-xs btn-danger rounded-0"
                                                    @click="requestRemoveFamilyLoan(item.loan_source,index)">
                                                <i class="fa fa-remove"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <small class="text-danger">
                                    * {{ maxCount - $parent.formData.familyLoans.length }} Family Loan remaining!
                                </small>
                            </div>
                        </div>
                    </div>
                    <div v-if="maxCount != $parent.formData.familyLoans.length" class="col-lg-12 col-md-12 col-sm-12">
                        <form data-vv-scope="l_v" @submit.prevent="onLoanSubmit('l_v')">
                            <div class="row">
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Source of Loan<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <select v-model.number="loanData.loan_source" v-validate="'required'"
                                                    :class="[(vvErrors.has('l_v.loan_source') ? 'is-invalid' : '')]"
                                                    class="form-control form-control-sm rounded-0"
                                                    data-vv-as="Source of Loan" data-vv-name="loan_source">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in $parent.initData.loanSourceTypes"
                                                        :key="index" :value="item">
                                                    {{ item }}
                                                </option>
                                            </select>
                                            <div v-if="vvErrors.has('l_v.loan_source')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_source') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Name of Loan Source<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="loanData.loan_source_name"
                                                   v-validate="'required|name_with_number|max:10'"
                                                   :class="[(vvErrors.has('l_v.loan_source_name') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="source name"
                                                   data-vv-name="loan_source_name" type="text">
                                            <div v-if="vvErrors.has('l_v.loan_source_name')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_source_name') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Date of Talking<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="loanData.loan_taking_date"
                                                   v-validate="'required|date_format:yyyy-mm-dd|max:30'"
                                                   :class="[(vvErrors.has('l_v.loan_taking_date') ? 'is-invalid' : '')]"
                                                   autocomplete="off"
                                                   class="form-control form-control-sm rounded-0 loan-datepicker"
                                                   data-vv-as="Date of Talking Loan"
                                                   data-vv-name="loan_taking_date"
                                                   name="loan_taking_date" type="text">
                                            <div v-if="vvErrors.has('l_v.loan_taking_date')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_taking_date') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Amount<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="loanData.loan_amount"
                                                   v-validate="'required|numeric|max:10'"
                                                   :class="[(vvErrors.has('l_v.loan_amount') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="loan amount" data-vv-name="loan_amount" type="text">
                                            <div v-if="vvErrors.has('l_v.loan_amount')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_amount') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Rate / Extra Amount</label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="loanData.loan_rate_or_extra_amount"
                                                   v-validate="'numeric|max:10'"
                                                   :class="[(vvErrors.has('l_v.loan_rate_or_extra_amount') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="rate or extra amount"
                                                   data-vv-name="loan_rate_or_extra_amount" type="text">
                                            <div v-if="vvErrors.has('l_v.loan_rate_or_extra_amount')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_rate_or_extra_amount') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Duration<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="loanData.loan_duration"
                                                   v-validate="'required|name_with_number|max:20'"
                                                   :class="[(vvErrors.has('l_v.loan_duration') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="loan duration" data-vv-name="loan_duration" type="text">
                                            <div v-if="vvErrors.has('l_v.loan_duration')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_duration') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Loan Purpose<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <select v-model.number="loanData.loan_purpose" v-validate="'required'"
                                                    :class="[(vvErrors.has('l_v.loan_purpose') ? 'is-invalid' : '')]"
                                                    class="form-control form-control-sm rounded-0"
                                                    data-vv-as="loan purpose" data-vv-name="loan_purpose">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in $parent.initData.loanPurposeTypes"
                                                        :key="index" :value="item">
                                                    {{ item }}
                                                </option>
                                            </select>
                                            <div v-if="vvErrors.has('l_v.loan_purpose')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_purpose') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Outstanding Amount<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="loanData.loan_outstanding_amount"
                                                   v-validate="'required|numeric|max:10'"
                                                   :class="[(vvErrors.has('l_v.loan_outstanding_amount') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="Outstanding Amount"
                                                   data-vv-name="loan_outstanding_amount" type="text">
                                            <div v-if="vvErrors.has('l_v.loan_outstanding_amount')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_outstanding_amount') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 col-sm-6">
                                    <div class="form-group p-0 m-0">
                                        <label class="czm-xs">Remarks </label>
                                        <div class="input-group input-group-sm">
                                            <textarea v-model="loanData.loan_remarks"
                                                      v-validate="'name_with_number|min:2|max:998'"
                                                      :class="[(vvErrors.has('l_v.loan_remarks') ? 'is-invalid' : '')]"
                                                      class="form-control form-control-sm rounded-0"
                                                      data-vv-as="Remarks" data-vv-name="loan_remarks"
                                                      type="text"></textarea>
                                            <div v-if="vvErrors.has('l_v.loan_remarks')" class="invalid-feedback">
                                                {{ vvErrors.first('l_v.loan_remarks') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group d-inline-block mt-3">
                                <button class="btn btn-brand btn-sm btn-czm-green pull-left" style="margin-bottom: 4px"
                                        type="submit">
                                    <i class="fa fa-plus"></i>
                                    <span>Add Loan</span>
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
    name: "FamilyAssetCreateC",
    data() {
        return {
            totalAsset: 0,
            totalLoan: 0,
            errors: {},
            assetData: {
                asset_id: "",
                asset_quantity: "",
                asset_location: "",
                asset_value: 0,
            },
            loanData: {
                loan_taking_date: "",
                loan_source: "",
                loan_source_name: "",
                loan_amount: "",
                loan_rate_or_extra_amount: "",
                loan_duration: "",
                loan_purpose: "",
                loan_outstanding_amount: "",
                loan_remarks: "",
            },
            maxCount: 10,
        };
    },
    methods: {
        countAssetTotalValue() {
            let _this = this;
            _this.totalAsset = 0;
            if (this.$parent.formData.familyAssets.length > 0) {
                this.$parent.formData.familyAssets.forEach((item) => {
                    _this.totalAsset += item.asset_value;
                });
            }
        },
        getAssetName(id) {
            let name = "";
            this.$parent.initData.assets.forEach((item) => {
                if (item.id == id) {
                    name = item.name;
                }
            });
            return name;
        },
        onAssetSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addFamilyAsset();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addFamilyAsset() {
            let _this = this;
            this.$parent.formData.familyAssets.push(_this.assetData);
            this.countAssetTotalValue();
            _this.assetData = {};
            _this.assetData.name = "";
            _this.assetData.asset_id = "";
            _this.assetData.asset_quantity = "";
            _this.assetData.asset_location = "";
            _this.assetData.asset_value = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
        requestRemoveFamilyAsset(assetId, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    _this.getAssetName(assetId) +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeFamilyAsset(index);
                }
            });
        },
        removeFamilyAsset(index) {
            let _this = this;
            _this.$parent.formData.familyAssets.splice(index, 1);
            this.countAssetTotalValue();
        },

        countOutstandingTotalAmount() {
            let _this = this;
            _this.totalLoan = 0;
            if (this.$parent.formData.familyLoans.length > 0) {
                this.$parent.formData.familyLoans.forEach((item) => {
                    _this.totalLoan += item.loan_outstanding_amount;
                });
            }
        },
        onLoanSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addFamilyLoan();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addFamilyLoan() {
            let _this = this;
            _this.$parent.formData.familyLoans.push(_this.loanData);
            _this.countOutstandingTotalAmount();
            _this.loanData = {};
            _this.loanData.loan_taking_date = "";
            _this.loanData.loan_source = "";
            _this.loanData.loan_source_name = "";
            _this.loanData.loan_amount = "";
            _this.loanData.loan_rate_or_extra_amount = "";
            _this.loanData.loan_duration = "";
            _this.loanData.loan_purpose = "";
            _this.loanData.loan_outstanding_amount = "";
            _this.loanData.loan_remarks = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
        requestRemoveFamilyLoan(source, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    source +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeFamilyLoan(index);
                }
            });
        },
        removeFamilyLoan(index) {
            let _this = this;
            _this.$parent.formData.familyLoans.splice(index, 1);
            _this.countOutstandingTotalAmount();
        },
    },
    filters: {
        dateFormat(value) {
            if (!value) return "";
            return moment(value).format("MMM DD, YYYY");
        },
        textCapitalize(value) {
            if (!value) return "";
            value = value.toString();
            return value.charAt(0).toUpperCase() + value.slice(1);
        },
    },
    mounted() {
        let _this = this;
        $(".loan-datepicker")
            .datepicker({
                todayHighlight: true,
                format: "yyyy-mm-dd",
                startDate: "-200y",
                autoclose: true,
            })
            .on("changeDate", (event) => {
                let value = event.currentTarget.value;
                switch (event.currentTarget.name) {
                    case "loan_taking_date":
                        _this.loanData.loan_taking_date = value;
                        break;
                }
            });
    },
};
</script>

<style scoped>
</style>

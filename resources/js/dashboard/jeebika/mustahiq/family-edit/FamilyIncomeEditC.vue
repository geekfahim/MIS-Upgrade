<template>
    <div>
        <!-- Income -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #4dbd74 ;font-size: 1.09375rem">Incomes (Yearly)
                    <button class="btn btn-brand btn-success btn-sm pull-right" @click="addNewIncome">
                        <i class="fa fa-plus"></i>
                        <span>Add New Income</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Income</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in incomes" :key=index>
                    <td>{{ item.income ? item.income.name : '' }}</td>
                    <td>{{ item.income_amount }}</td>
                    <td>{{ item.income_remarks }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editIncome(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteIncome(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="incomes.length === 0">
                    <td class="text-center" colspan="4">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Income Create/Edit Modal -->
        <div id="incomeCreateEditModal" aria-hidden="true" aria-labelledby="Income Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="incomeScope"
                              v-on:submit.prevent="submitIncome('incomeScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Income</strong>
                                    <strong v-else>Update Income</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Source of Income<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="incomeFormData.income_id" v-validate="'required'"
                                            :class="[(vvErrors.has('incomeScope.income_id') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0" data-vv-as="income"
                                            data-vv-name="income_id" data-vv-validate-on="change">
                                        <option value="">Select One</option>
                                        <option v-for="(item,index) in sources" :key="index" :value="item.id">
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('incomeScope.income_id')" class="invalid-feedback">
                                        {{ vvErrors.first('incomeScope.income_id') }}
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
                                    <input v-model.number="incomeFormData.income_amount"
                                           v-validate="'required|numeric|max_value:10000000'"
                                           :class="[(vvErrors.has('incomeScope.income_amount') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="amount" data-vv-name="income_amount"

                                           type="text">
                                    <div v-show="vvErrors.has('incomeScope.income_amount')" class="invalid-feedback">
                                        {{ vvErrors.first('incomeScope.income_amount') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <textarea v-model="incomeFormData.income_remarks"
                                          v-validate="'name_with_number|max:900'"
                                          :class="[(vvErrors.has('incomeScope.income_remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4" data-vv-as="remarks" data-vv-name="income_remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('incomeScope.income_remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('incomeScope.income_remarks') }}
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
        <!-- Expense -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #63c2de;font-size: 1.09375rem">Expenses (Yearly)
                    <button class="btn btn-brand btn-info btn-sm pull-right" @click="addNewExpense">
                        <i class="fa fa-plus"></i>
                        <span>Add New Expense</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Expense Type</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in expenses" :key=index>
                    <td>{{ item.expense_type }}</td>
                    <td>{{ item.expense_amount }}</td>
                    <td>{{ item.expense_remarks }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editExpense(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteExpense(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="expenses.length === 0">
                    <td class="text-center" colspan="4">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Expense Create/Edit Modal -->
        <div id="expenseCreateEditModal" aria-hidden="true" aria-labelledby="Expense Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="expenseScope"
                              v-on:submit.prevent="submitExpense('expenseScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Expense</strong>
                                    <strong v-else>Update Expense</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Expense Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="expenseFormData.expense_type" v-validate="'required'"
                                            :class="[(vvErrors.has('expenseScope.expense_type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0"
                                            data-vv-as="expense type"
                                            data-vv-name="expense_type">
                                        <option value="">Select One</option>
                                        <option v-for="item in EXPENSE_TYPES" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('expenseScope.expense_type')" class="invalid-feedback">
                                        {{ vvErrors.first('expenseScope.expense_type') }}
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
                                    <input v-model.number="expenseFormData.expense_amount"
                                           v-validate="'required|numeric|max_value:10000000'"
                                           :class="[(vvErrors.has('expenseScope.expense_amount') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0"
                                           data-vv-as="amount" data-vv-name="expense_amount" type="text">
                                    <div v-show="vvErrors.has('expenseScope.expense_amount')" class="invalid-feedback">
                                        {{ vvErrors.first('expenseScope.expense_amount') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <textarea v-model="expenseFormData.expense_remarks"
                                          v-validate="'name_with_number|max:900'"
                                          :class="[(vvErrors.has('expenseScope.expense_remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4"
                                          data-vv-as="remarks" data-vv-name="expense_remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('expenseScope.expense_remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('expenseScope.expense_remarks') }}
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
        <!-- Savings -->
        <div class="table-responsive">
            <table class="table table-responsive-sm table-sm table-striped table-hover">
                <caption style="color: #321fdb;font-size: 1.09375rem">Savings (Yearly)
                    <button class="btn btn-brand btn-primary btn-sm pull-right" @click="addNewSaving">
                        <i class="fa fa-plus"></i>
                        <span>Add New Saving</span>
                    </button>
                </caption>
                <thead>
                <tr>
                    <th>Saving Type</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                    <th style="width: 145px; text-align:center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in savings" :key=index>
                    <td>{{ item.savings_type }}</td>
                    <td>{{ item.savings_amount }}</td>
                    <td>{{ item.savings_remarks }}</td>
                    <td>
                        <button class="btn btn-xs btn-info rounded-0" @click="editSaving(item)">
                            <i class="fa fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-xs btn-danger rounded-0" @click="deleteSaving(item)">
                            <i class="fa fa-remove"></i> Delete
                        </button>
                    </td>
                </tr>
                <tr v-if="savings.length === 0">
                    <td class="text-center" colspan="4">No Data Found</td>
                </tr>
                </tbody>
            </table>
        </div>
        <!-- Savings Create/Edit Modal -->
        <div id="savingCreateEditModal" aria-hidden="true" aria-labelledby="Saving Modal" class="modal fade"
             role="dialog" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-body">
                        <form class="form-horizontal" data-vv-scope="savingScope"
                              v-on:submit.prevent="submitSaving('savingScope')">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Saving</strong>
                                    <strong v-else>Update Saving</strong>
                                </h6>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Saving Type<span class="text-danger">*</span></label>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                          <i class="fa fa-arrow-circle-down"></i>
                                        </span>
                                    </div>
                                    <select v-model.number="savingFormData.savings_type" v-validate="'required'"
                                            :class="[(vvErrors.has('savingScope.savings_type') ? 'is-invalid' : '')]"
                                            class="form-control form-control-sm rounded-0" data-vv-as="saving type"
                                            data-vv-name="savings_type" data-vv-validate-on="change">
                                        <option value="">Select One</option>
                                        <option v-for="item in SAVINGS_TYPES" :key="item" :value="item">
                                            {{ item }}
                                        </option>
                                    </select>
                                    <div v-show="vvErrors.has('savingScope.savings_type')" class="invalid-feedback">
                                        {{ vvErrors.first('savingScope.savings_type') }}
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
                                    <input v-model.number="savingFormData.savings_amount"
                                           v-validate="'required|numeric|max_value:10000000'"
                                           :class="[(vvErrors.has('savingScope.savings_amount') ? 'is-invalid' : '')]"
                                           class="form-control form-control-sm rounded-0" data-vv-as="amount"
                                           data-vv-name="savings_amount" type="text">
                                    <div v-show="vvErrors.has('savingScope.savings_amount')" class="invalid-feedback">
                                        {{ vvErrors.first('savingScope.savings_amount') }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="czm-xs">Remarks</label>
                                <textarea v-model="savingFormData.savings_remarks"
                                          v-validate="'name_with_number|max:900'"
                                          :class="[(vvErrors.has('savingScope.savings_remarks') ? 'is-invalid' : '')]"
                                          class="form-control form-control-sm rounded-0"
                                          cols="4" data-vv-as="remarks" data-vv-name="savings_remarks"
                                          placeholder="type here"></textarea>
                                <div v-show="vvErrors.has('savingScope.savings_remarks')" class="invalid-feedback">
                                    {{ vvErrors.first('savingScope.savings_remarks') }}
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
    name: "FamilyIncomeEditC",
    data() {
        return {
            //common
            createView: true,
            //Income
            sources: [],
            incomes: [],
            incomeFormData: {
                id: '',
                income_id: '',
                income_amount: '',
                income_remarks: ''
            },
            //Expense
            expenses: [],
            EXPENSE_TYPES: [],
            expenseFormData: {
                id: '',
                expense_type: '',
                expense_amount: '',
                expense_remarks: ''
            },
            //Saving
            savings: [],
            SAVINGS_TYPES: [],
            savingFormData: {
                id: '',
                savings_type: '',
                savings_amount: '',
                savings_remarks: ''
            },
        }
    },
    methods: {
        /* Income */
        editIncome(item) {
            this.createView = false;
            this.incomeFormData = {};
            this.incomeFormData.id = item.id;
            this.incomeFormData.income_id = item.income_id;
            this.incomeFormData.income_amount = item.income_amount;
            this.incomeFormData.income_remarks = item.income_remarks;
            this.$validator.reset();
            $("#incomeCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteIncome(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.income ? item.income.name : ''}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.income + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllIncomes();
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
        submitIncome(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addIncome();
                } else if (result && !_this.createView) {
                    _this._updateIncome();
                }
            });
        },
        _addIncome() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.income, _this.incomeFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllIncomes();
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
        _updateIncome() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.income + "/" + _this.incomeFormData.id, _this.incomeFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllIncomes();
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
        addNewIncome() {
            this.createView = true;
            this.incomeFormData = {};
            this.incomeFormData.income_id = "";
            this.incomeFormData.income_amount = "";
            this.incomeFormData.income_remarks = "";
            this.$validator.reset();
            $("#incomeCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllIncomes() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            axios.get(this.$parent.routes.income).then((res) => {
                if (res.data) {
                    _this.incomes = res.data.lists;
                    _this.sources = res.data.sources;
                    $('#incomeCreateEditModal').modal('hide');
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
        /* Expense */
        editExpense(item) {
            this.createView = false;
            this.expenseFormData = {};
            this.expenseFormData.id = item.id;
            this.expenseFormData.expense_type = item.expense_type;
            this.expenseFormData.expense_amount = item.expense_amount;
            this.expenseFormData.expense_remarks = item.expense_remarks;
            this.$validator.reset();
            $("#expenseCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteExpense(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.expense_type}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.expense + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllExpenses();
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
        submitExpense(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addExpense();
                } else if (result && !_this.createView) {
                    _this._updateExpense();
                }
            });
        },
        _addExpense() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.expense, _this.expenseFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllExpenses();
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
        _updateExpense() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.expense + "/" + _this.expenseFormData.id, _this.expenseFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllExpenses();
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
        addNewExpense() {
            this.createView = true;
            this.expenseFormData = {};
            this.expenseFormData.expense_type = "";
            this.expenseFormData.expense_amount = "";
            this.expenseFormData.expense_remarks = "";
            this.$validator.reset();
            $("#expenseCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllExpenses() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.expenseFormData = {};
            axios.get(this.$parent.routes.expense).then((res) => {
                if (res.data) {
                    _this.expenses = res.data.lists;
                    _this.EXPENSE_TYPES = res.data.EXPENSE_TYPES;
                    $('#expenseCreateEditModal').modal('hide');
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
        /* Saving */
        editSaving(item) {
            this.createView = false;
            this.savingFormData = {};
            this.savingFormData.id = item.id;
            this.savingFormData.savings_type = item.savings_type;
            this.savingFormData.savings_amount = item.savings_amount;
            this.savingFormData.savings_remarks = item.savings_remarks;
            this.$validator.reset();
            $("#savingCreateEditModal").modal({show: true, backdrop: "static"});
        },
        deleteSaving(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure to delete?",
                html: `<p style="color:#3085d6">${item.savings_type}</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#2778c4",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.loading = true;
                    _this.errors = {};
                    axios.delete(this.$parent.routes.saving + "/" + item.id).then((res) => {
                        if (res.data.success) {
                            Swal.fire("Deleted!", res.data.success, "success");
                            _this.getAllSavings();
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
        submitSaving(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result && _this.createView) {
                    _this._addSaving();
                } else if (result && !_this.createView) {
                    _this._updateSaving();
                }
            });
        },
        _addSaving() {
            let _this = this;
            _this.loading = true;
            axios.post(this.$parent.routes.saving, _this.savingFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllSavings();
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
        _updateSaving() {
            let _this = this;
            _this.loading = true;
            axios.put(this.$parent.routes.saving + "/" + _this.savingFormData.id, _this.savingFormData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAllSavings();
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
        addNewSaving() {
            this.createView = true;
            this.savingFormData = {};
            this.savingFormData.savings_type = "";
            this.savingFormData.savings_amount = "";
            this.savingFormData.savings_remarks = "";
            this.$validator.reset();
            $("#savingCreateEditModal").modal({show: true, backdrop: "static"});
        },
        getAllSavings() {
            let _this = this;
            _this.formView = false;
            // this.$parent.loading = true;
            _this.createView = true;
            _this.savingFormData = {};
            axios.get(this.$parent.routes.saving).then((res) => {
                if (res.data) {
                    _this.savings = res.data.lists;
                    _this.SAVINGS_TYPES = res.data.SAVINGS_TYPES;
                    $('#savingCreateEditModal').modal('hide');
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
        this.getAllIncomes();
        this.getAllExpenses();
        this.getAllSavings();
    }
}
</script>

<style scoped>

</style>

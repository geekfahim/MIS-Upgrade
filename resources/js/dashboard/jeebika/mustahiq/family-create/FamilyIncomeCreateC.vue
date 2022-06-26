<template>
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Family Income (Yearly)</h5>
                <div class="text-danger">
                    <span>Total Value: {{ totalIncome }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div v-if="$parent.formData.familyIncomes.length > 0" class="form-group">
                        <div class="table-responsive">
                            <table class="table table-sm table-stripe">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th>Income Type</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item,index) in $parent.formData.familyIncomes" :key="index">
                                    <td>{{ getIncomeSourceName(item.income_source_id) }}</td>
                                    <td>{{ item.income_amount }}</td>
                                    <td>{{ item.income_remarks }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-danger rounded-0"
                                                @click="requestRemoveFamilyIncome(item.income_source_id,index)">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <small class="text-danger">
                                * {{ maxCount - $parent.formData.familyIncomes.length }} income remaining!
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div v-if="maxCount != $parent.formData.familyIncomes.length" class="col-lg-12 col-md-12 col-sm-12">
                        <form data-vv-scope="i_v" @submit.prevent="onIncomeSubmit('i_v')">
                            <div class="row">
                                <div class="col-lg-4 col-md-2 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Source of Income<span
                                            class="text-danger">*</span></label>
                                        <select v-model="incomeData.income_source_id"
                                                v-validate="'required'"
                                                :class="[this.vvErrors.has('i_v.income_source_id') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0"
                                                data-vv-as="Source of Income" data-vv-name="income_source_id">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in $parent.initData.incomes" :key="index"
                                                    :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('i_v.income_source_id')" class="invalid-feedback">
                                            {{ vvErrors.first("i_v.income_source_id") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Amount<span class="text-danger">*</span></label>
                                        <input v-model.number="incomeData.income_amount"
                                               v-validate="'required|numeric|max:150'"
                                               :class="[(vvErrors.has('i_v.income_amount') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="income amount" data-vv-name="income_amount"
                                               type="text">
                                        <div v-show="vvErrors.has('i_v.income_amount')" class="invalid-feedback">
                                            {{ vvErrors.first("i_v.income_amount") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Remarks</label>
                                        <textarea v-model="incomeData.income_remarks" v-validate="'min:2|max:998'"
                                                  :class="[(vvErrors.has('i_v.income_remarks') ? 'is-invalid' : '')]"
                                                  class="form-control form-control-sm rounded-0"
                                                  data-vv-as="income_remarks" data-vv-name="income_remarks"
                                                  type="text"></textarea>
                                        <div v-show="vvErrors.has('i_v.income_remarks')" class="invalid-feedback">
                                            {{ vvErrors.first("i_v.income_remarks") }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <button class="btn btn-brand btn-sm btn-czm-green pull-left" style="margin-bottom: 4px"
                                        type="submit">
                                    <i class="fa fa-plus"></i>
                                    <span>Add Income </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <small class="text-danger"> * All Amount are yearly based.</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Family Expense (Yearly)</h5>
                <div class="text-danger">
                    <span>Total Expense: {{ totalExpense }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div v-if="$parent.formData.familyExpenses.length > 0" class="form-group">
                        <div class="table-responsive">
                            <table class="table table-sm table-stripe">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th>Expense Type</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item,index) in $parent.formData.familyExpenses" :key="index">
                                    <td>{{ item.expense_type }}</td>
                                    <td>{{ item.expense_amount }}</td>
                                    <td>{{ item.expense_remarks }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-danger rounded-0"
                                                @click="requestRemoveFamilyExpense(item.expense_type,index)">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <small class="text-danger">
                                * {{ maxCount - $parent.formData.familyExpenses.length }} expense remaining!
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form data-vv-scope="e_v" @submit.prevent="onExpenseSubmit('e_v')">
                            <div v-if="$parent.formData.familyExpenses.length < maxCount" class="row">
                                <div class="col-lg-4 col-md-2 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Expense Type<span class="text-danger">*</span></label>
                                        <select v-model.number="expenseData.expense_type"
                                                v-validate="'required'"
                                                :class="[this.vvErrors.has('e_v.expense_type') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0" data-vv-as="expense Type"
                                                data-vv-name="expense_type">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in $parent.initData.expenseTypes" :key="index"
                                                    :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('e_v.expense_type')" class="invalid-feedback">
                                            {{ vvErrors.first("e_v.expense_type") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Amount<span class="text-danger">*</span></label>
                                        <input v-model.number="expenseData.expense_amount"
                                               v-validate="'required|numeric|max:150'"
                                               :class="[(vvErrors.has('e_v.expense_amount') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="income amount" data-vv-name="expense_amount"
                                               type="text">
                                        <div v-show="vvErrors.has('e_v.expense_amount')" class="invalid-feedback">
                                            {{ vvErrors.first("e_v.expense_amount") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Remarks</label>
                                        <textarea v-model="expenseData.expense_remarks" v-validate="'min:2|max:998'"
                                                  :class="[(vvErrors.has('e_v.expense_remarks') ? 'is-invalid' : '')]"
                                                  class="form-control form-control-sm rounded-0"
                                                  data-vv-as="expesne remarks" data-vv-name="expense_remarks"
                                                  type="text"></textarea>
                                        <div v-show="vvErrors.has('e_v.expense_remarks')" class="invalid-feedback">
                                            {{ vvErrors.first("e_v.expense_remarks") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 form-group mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Expense</span>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <small class="text-danger"> * All Amount are yearly based.</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Family Savings (yearly)</h5>
                <div class="text-danger">
                    <span>Total Value: {{ totalSavings }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div v-if="$parent.formData.familySavings.length > 0" class="form-group">
                        <div class="table-responsive">
                            <table class="table table-sm table-stripe">
                                <thead class="bg-gray-100">
                                <tr>
                                    <th>Savings Type</th>
                                    <th>Amount</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(item,index) in $parent.formData.familySavings" :key="index">
                                    <td>{{ item.savings_type }}</td>
                                    <td>{{ item.savings_amount }}</td>
                                    <td>{{ item.savings_remarks }}</td>
                                    <td>
                                        <button class="btn btn-xs btn-danger rounded-0"
                                                @click="requestRemoveFamilySavings(item.savings_type,index)">
                                            <i class="fa fa-remove"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <small class="text-danger">
                                * {{ maxCount - $parent.formData.familySavings.length }} saving remaining!
                            </small>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form data-vv-scope="s_v" @submit.prevent="onSavingSubmit('s_v')">
                            <div v-if="$parent.formData.familySavings.length < maxCount" class="row">
                                <div class="col-lg-4 col-md-2 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Savings Type<span class="text-danger">*</span></label>
                                        <select v-model.number="savingData.savings_type"
                                                v-validate="'required'"
                                                :class="[this.vvErrors.has('s_v.savings_type') ? 'is-invalid' : '']"
                                                class="form-control form-control-sm rounded-0" data-vv-as="savings Type"
                                                data-vv-name="savings_type">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in $parent.initData.savingsTypes" :key="index"
                                                    :value="item">
                                                {{ item }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('s_v.savings_type')" class="invalid-feedback">
                                            {{ vvErrors.first("s_v.savings_type") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Amount<span class="text-danger">*</span></label>
                                        <input v-model.number="savingData.savings_amount"
                                               v-validate="'required|numeric|max:150'"
                                               :class="[(vvErrors.has('s_v.savings_amount') ? 'is-invalid' : '')]"
                                               class="form-control form-control-sm rounded-0"
                                               data-vv-as="savings amount" data-vv-name="savings_amount"
                                               type="text">
                                        <div v-show="vvErrors.has('s_v.savings_amount')" class="invalid-feedback">
                                            {{ vvErrors.first("s_v.savings_amount") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="form-group p-0 m-0">
                                        <label class="mb-0 pl-1">Remarks</label>
                                        <textarea v-model="savingData.savings_remarks" v-validate="'min:2|max:998'"
                                                  :class="[(vvErrors.has('s_v.savings_remarks') ? 'is-invalid' : '')]"
                                                  class="form-control form-control-sm rounded-0"
                                                  data-vv-as="savings remarks" data-vv-name="savings_remarks"
                                                  type="text"></textarea>
                                        <div v-show="vvErrors.has('s_v.savings_remarks')" class="invalid-feedback">
                                            {{ vvErrors.first("s_v.savings_remarks") }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12 form-group mt-3">
                                    <button class="btn btn-brand btn-sm btn-czm-green pull-left"
                                            style="margin-bottom: 4px"
                                            type="submit">
                                        <i class="fa fa-plus"></i>
                                        <span>Add Savings</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <small class="text-danger"> * All Amount are yearly based.</small>
            </div>
        </div>

    </div>
</template>
<script>
export default {
    name: "FamilyIncomeCreateC",
    data() {
        return {
            errors: {},
            maxCount: 10,
            totalIncome: 0,
            totalExpense: 0,
            totalSavings: 0,
            incomeData: {
                income_source_id: "",
                income_amount: "",
                income_remarks: "",
            },
            expenseData: {
                expense_type: "",
                expense_amount: "",
                expense_remarks: "",
            },
            savingData: {
                savings_type: "",
                savings_amount: "",
                savings_remarks: "",
            },
        };
    },
    methods: {
        onIncomeSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addFamilyIncome();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        getIncomeSourceName(id) {
            let _this = this;
            let name = "";
            _this.$parent.initData.incomes.forEach((item) => {
                if (item.id == id) {
                    name = item.name;
                }
            });
            return name;
        },
        addFamilyIncome() {
            let _this = this;
            _this.$parent.formData.familyIncomes.push(_this.incomeData);
            _this.totalFamilyIncome();
            _this.incomeData = {};
            _this.incomeData.income_source_id = "";
            _this.incomeData.income_amount = "";
            _this.incomeData.income_remarks = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        totalFamilyIncome() {
            let _this = this;
            _this.totalIncome = 0;
            if (_this.$parent.formData.familyIncomes.length > 0) {
                _this.$parent.formData.familyIncomes.forEach((item) => {
                    _this.totalIncome += item.income_amount;
                });
            }
        },
        requestRemoveFamilyIncome(incomeSourceId, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    _this.getIncomeSourceName(incomeSourceId) +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeFamilyIncome(index);
                }
            });
        },
        removeFamilyIncome(index) {
            let _this = this;
            _this.$parent.formData.familyIncomes.splice(index, 1);
            _this.totalFamilyIncome();
        },
        onExpenseSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addFamilyExpense();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addFamilyExpense() {
            let _this = this;
            _this.$parent.formData.familyExpenses.push(_this.expenseData);
            _this.totalFamilyExpense();
            _this.expenseData = {};
            _this.expenseData.expense_remarks = "";
            _this.expenseData.expense_type = "";
            _this.expenseData.expense_amount = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        totalFamilyExpense() {
            let _this = this;
            _this.totalExpense = 0;
            if (_this.$parent.formData.familyExpenses.length > 0) {
                _this.$parent.formData.familyExpenses.forEach((item) => {
                    _this.totalExpense += item.expense_amount;
                });
            }
        },
        requestRemoveFamilyExpense(expenseType, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    expenseType +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeFamilyExpense(index);
                }
            });
        },
        removeFamilyExpense(index) {
            let _this = this;
            _this.$parent.formData.familyExpenses.splice(index, 1);
            _this.totalFamilyExpense();
        },
        onSavingSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addFamilySaving();
                } else {
                    _this.errors = _this.vvErrors.collect();
                }
            });
        },
        addFamilySaving() {
            let _this = this;
            _this.$parent.formData.familySavings.push(_this.savingData);
            _this.totalFamilySavings();
            _this.savingData = {};
            _this.savingData.savings_type = "";
            _this.savingData.savings_amount = "";
            _this.savingData.savings_remarks = "";
            _this.savingData.savings_type = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
                _this.errors = {};
            });
        },
        totalFamilySavings() {
            let _this = this;
            _this.totalSavings = 0;
            if (_this.$parent.formData.familySavings.length > 0) {
                _this.$parent.formData.familySavings.forEach((item) => {
                    _this.totalSavings += item.savings_amount;
                });
            }
        },
        requestRemoveFamilySavings(savingType, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    savingType +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeFamilySavings(index);
                }
            });
        },
        removeFamilySavings(index) {
            let _this = this;
            _this.$parent.formData.familySavings.splice(index, 1);
            _this.totalFamilySavings();
        },
    },
};
</script>
<style scoped>
</style>

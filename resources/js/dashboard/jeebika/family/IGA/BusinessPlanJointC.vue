<template>
    <div class="position-relative">
        <div class="card-header">
            <i class="fa fa-list"></i>
            Joint Business Plan
            <div class="card-header-actions p-0 m-0">
                <button v-if="!formView" class="btn btn-brand btn-sm btn-github" type="button" @click="addNew()">
                    <i class="fa fa-plus"></i>
                    <span>Add New Joint Business Plan</span>
                </button>
                <button v-else class="btn btn-brand btn-sm btn-github" type="button" @click="getAll()">
                    <i class="fa fa-list"></i>
                    <span>View All Joint Business Plan</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div v-show="formView">
                <div v-if="!isEmpty(errors)" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div v-html="errorHtml"></div>
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                        <form class="form-horizontal">
                            <div class="form-group row justify-content-center">
                                <h6 class="text-left col-sm-12">
                                    <strong v-if="createView">Add New Joint Business</strong>
                                    <strong v-else>Update</strong>
                                </h6>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Business Name<span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="formData.business_name"
                                                   v-validate="'required|name_with_number|min:2|max:50'"
                                                   :class="[(vvErrors.has('business_name') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="name" data-vv-name="business_name"
                                                   type="text">
                                            <div v-show="vvErrors.has('business_name')" class="invalid-feedback">
                                                {{ vvErrors.first('business_name') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Business Type <span class="text-danger">*</span></label>
                                        <select v-model="formData.j_investment_area_id"
                                                v-validate="'required'"
                                                :class="[(vvErrors.has('j_investment_area_id') ? 'is-invalid' : '')]"
                                                class="form-control form-control-sm"
                                                data-vv-as="type"
                                                data-vv-name="j_investment_area_id">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in investmentAreas" :key="index"
                                                    :value="item.id">
                                                {{ item.name }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('j_investment_area_id')" class="invalid-feedback">
                                            {{ vvErrors.first('j_investment_area_id') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Business Duration (month)<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="formData.business_duration"
                                                   v-validate="'required|numeric|min:1|max:4'"
                                                   :class="[(vvErrors.has('business_duration') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="duration" data-vv-name="business_duration"
                                                   type="text">
                                            <div v-show="vvErrors.has('business_duration')" class="invalid-feedback">
                                                {{ vvErrors.first('business_duration') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Business Seed Money <span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="formData.business_seed_money"
                                                   v-validate="'required|numeric|min:2|max:6'"
                                                   :class="[(vvErrors.has('business_seed_money') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="seed money" data-vv-name="business_seed_money"
                                                   type="text">
                                            <div v-show="vvErrors.has('business_seed_money')" class="invalid-feedback">
                                                {{ vvErrors.first('business_seed_money') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Possible Gross Income <span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="formData.possible_gross_income"
                                                   v-validate="'required|numeric|min:1|max:6'"
                                                   :class="[(vvErrors.has('possible_gross_income') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="gross income" data-vv-name="possible_gross_income"
                                                   type="text">
                                            <div v-show="vvErrors.has('possible_gross_income')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first('possible_gross_income') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Possible Gross Expense <span class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="formData.possible_gross_expense"
                                                   v-validate="'required|numeric|min:1|max:6'"
                                                   :class="[(vvErrors.has('possible_gross_expense') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="gross expense"
                                                   data-vv-name="possible_gross_expense"
                                                   type="text">
                                            <div v-show="vvErrors.has('possible_gross_expense')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first('possible_gross_expense') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Investment Return Type<span
                                            class="text-danger">*</span></label>
                                        <select v-model="formData.investment_return_type"
                                                v-validate="'required'"
                                                :class="[(vvErrors.has('investment_return_type') ? 'is-invalid' : '')]"
                                                class="form-control form-control-sm"
                                                data-vv-as="return type"
                                                data-vv-name="investment_return_type">
                                            <option value="">Select One</option>
                                            <option v-for="(item,index) in investmentReturnTypes" :key="index"
                                                    :value="item">{{ item }}
                                            </option>
                                        </select>
                                        <div v-show="vvErrors.has('investment_return_type')" class="invalid-feedback">
                                            {{ vvErrors.first('investment_return_type') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Investment Return Amount Each <span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model.number="formData.investment_return_amount_each"
                                                   v-validate="'required|numeric|min:2|max:6'"
                                                   :class="[(vvErrors.has('investment_return_amount_each') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="each return amount"
                                                   data-vv-name="investment_return_amount_each"
                                                   type="text">
                                            <div v-show="vvErrors.has('investment_return_amount_each')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first('investment_return_amount_each') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="czm-xs">Assist in Business<span
                                            class="text-danger">*</span></label>
                                        <div class="input-group input-group-sm">
                                            <input v-model="formData.business_assist"
                                                   v-validate="'required|name_with_number|min:2|max:50'"
                                                   :class="[(vvErrors.has('business_assist') ? 'is-invalid' : '')]"
                                                   class="form-control form-control-sm rounded-0"
                                                   data-vv-as="Assist in Business"
                                                   data-vv-name="business_assist" placeholder="ex:wife,brother,sister"
                                                   type="text">
                                            <div v-show="vvErrors.has('business_assist')" class="invalid-feedback">
                                                {{ vvErrors.first('business_assist') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="czm-xs">Business Experience <span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input id="is_business_experience_true"
                                               v-model="formData.is_business_experience" class="form-check-input"
                                               name="is_business_experience" type="radio" value="true"/>
                                        <label class="form-check-label" for="is_business_experience_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="is_business_experience_false"
                                               v-model="formData.is_business_experience" class="form-check-input"
                                               name="is_business_experience" type="radio" value="false"/>
                                        <label class="form-check-label" for="is_business_experience_false">No</label>
                                    </div>
                                    <div v-if="'true'==formData.is_business_experience">
                                        <div class="form-group">
                                            <label class="czm-xs">Experience (Month)<span
                                                class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model.number="formData.business_experience_duration"
                                                       v-validate="'required|numeric|min:1|max:4'"
                                                       :class="[(vvErrors.has('business_experience_duration') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="experience"
                                                       data-vv-name="business_experience_duration"
                                                       type="text">
                                                <div v-show="vvErrors.has('business_experience_duration')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('business_experience_duration') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label class="czm-xs">Business Training</label>
                                    <div class="form-check form-check-inline">
                                        <input id="is_business_training_true" v-model="formData.is_business_training"
                                               class="form-check-input" name="is_business_training" type="radio"
                                               value="true"/>
                                        <label class="form-check-label" for="is_business_training_true">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input id="is_business_training_false" v-model="formData.is_business_training"
                                               class="form-check-input" name="is_business_training" type="radio"
                                               value="false"/>
                                        <label class="form-check-label" for="is_business_training_false">No</label>
                                    </div>
                                    <div v-if="'true'=== formData.is_business_training">
                                        <div class="form-group">
                                            <label class="czm-xs">Training (Month)<span
                                                class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model.number="formData.business_training_duration"
                                                       v-validate="'required|numeric|min:1|max:4'"
                                                       :class="[(vvErrors.has('business_training_duration') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="training duration"
                                                       data-vv-name="business_training_duration"
                                                       type="text">
                                                <div v-show="vvErrors.has('business_training_duration')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('business_training_duration') }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="czm-xs">Training Institute Name<span
                                                class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model="formData.business_training_institute_name"
                                                       v-validate="'required|name_with_number|min:2|max:50'"
                                                       :class="[(vvErrors.has('business_training_institute_name') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="training institute name"
                                                       data-vv-name="business_training_institute_name"
                                                       type="text">
                                                <div v-show="vvErrors.has('business_training_institute_name')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('business_training_institute_name') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="source">
                            <div class="form-group row justify-content-between my-4">
                                <h6 class="">
                                    <strong>Capital Partner Families</strong>
                                </h6>
                                <h6 class="text-danger">
                                    <strong>Amount: {{ totalSourceCapital }}</strong>
                                </h6>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div v-if="sourceCapitals.length > 0" class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-stripe">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th>Capital Partner Family Name</th>
                                                <th>Amount</th>
                                                <th>Remarks</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in sourceCapitals" :key="index">
                                                <td style="min-width: 300px;">
                                                    {{ getFamilyName(item.partner_id) }}
                                                </td>
                                                <td class="tk" style="min-width: 100px;">{{ item.source_amount }}</td>
                                                <td style="max-width: 300px;">{{ item.source_remarks }}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-danger rounded-0"
                                                            @click="requestRemoveSourceCapital(item.partner_id,index)">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <small class="text-danger">
                                            * {{ maxCount - sourceCapitals.length }} capital partner remaining!
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <form v-if="maxCount != sourceCapitals.length" data-vv-scope="v_scope"
                                  @submit.prevent="onSourceCapitalSubmit('v_scope')">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="czm-xs">Family Name <span class="text-danger">*</span></label>
                                            <select v-model.number="sourceData.partner_id"
                                                    v-validate="'required'"
                                                    :class="[(vvErrors.has('v_scope.partner_id') ? 'is-invalid' : '')]"
                                                    class="form-control form-control-sm" data-vv-as="family name"
                                                    data-vv-name="partner_id">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in families" :key="index" :value="item.id"
                                                        :disabled="selectedPartnerIds.includes(item.id)"
                                                        :style="[selectedPartnerIds.includes(item.id) ? {'color': 'white','background':'gray'} : {}]">
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('v_scope.partner_id')" class="invalid-feedback">
                                                {{ vvErrors.first('v_scope.partner_id') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="czm-xs">Amount <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model.number="sourceData.source_amount"
                                                       v-validate="'required|numeric|min:2|max:6'"
                                                       :class="[(vvErrors.has('v_scope.source_amount') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="amount" data-vv-name="source_amount"
                                                       type="text">
                                                <div v-show="vvErrors.has('v_scope.source_amount')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('v_scope.source_amount') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="mb-0 pl-1 czm-xs">Remarks(If Any)</label>
                                            <textarea v-model="sourceData.source_remarks"
                                                      v-validate="'name_with_number|max:499'"
                                                      :class="[this.vvErrors.has('v_scope.source_remarks') ? 'is-invalid' : '']"
                                                      class="form-control rounded-0" data-vv-as="remarks"
                                                      data-vv-name="source_remarks"></textarea>
                                            <div v-show="vvErrors.has('v_scope.source_remarks')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("v_scope.source_remarks") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-brand btn-sm btn-czm-green" type="submit">
                                            <i class="fa fa-plus"></i><span>Add Partner</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="field">
                            <div class="form-group row justify-content-between my-4">
                                <h6 class="">
                                    <strong>Field of Capital Expense</strong>
                                </h6>
                                <h6 class="text-danger">
                                    <strong>Total Price: {{ totalFieldCapital }}</strong>
                                </h6>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div v-if="fieldCapitals.length > 0" class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-stripe">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th>Field Name</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in fieldCapitals" :key="index">
                                                <td class="text-capitalize">{{ item.field_name }}</td>
                                                <td class="text-capitalize">{{ item.field_unit_price }}</td>
                                                <td class="text-capitalize">{{ item.field_quantity }}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-danger rounded-0"
                                                            @click="requestRemoveFieldCapital(item.field_name,index)">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <small class="text-danger">
                                            * {{ maxCount - fieldCapitals.length }} field of capital remaining!
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <form v-if="maxCount != fieldCapitals.length" data-vv-scope="f_scope"
                                  @submit.prevent="onFieldCapitalSubmit('f_scope')">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="czm-xs">Expense Name <span
                                                class="text-danger">*</span></label>
                                            <select v-model="fieldData.field_name" v-validate="'required'"
                                                    :class="[(vvErrors.has('f_scope.field_name') ? 'is-invalid' : '')]"
                                                    class="form-control form-control-sm"
                                                    data-vv-as="field name"
                                                    data-vv-name="field_name">
                                                <option value="">Select One</option>
                                                <option v-for="(item,index) in fieldCapitalTypes" :key="index"
                                                        :value="item">{{ item }}
                                                </option>
                                            </select>
                                            <div v-show="vvErrors.has('f_scope.field_name')" class="invalid-feedback">
                                                {{ vvErrors.first('f_scope.field_name') }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="czm-xs">Unit Price <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model.number="fieldData.field_unit_price"
                                                       v-validate="'required|numeric|min:2|max:6'"
                                                       :class="[(vvErrors.has('f_scope.field_unit_price') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="unit price" data-vv-name="field_unit_price"
                                                       type="text">
                                                <div v-show="vvErrors.has('f_scope.field_unit_price')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('f_scope.field_unit_price') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="czm-xs">Quantity <span class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model.number="fieldData.field_quantity"
                                                       v-validate="'required|numeric|min:1|max:4'"
                                                       :class="[(vvErrors.has('f_scope.field_quantity') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="quantity" data-vv-name="field_quantity"
                                                       type="text">
                                                <div v-show="vvErrors.has('f_scope.field_quantity')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('f_scope.field_quantity') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-brand btn-sm btn-czm-green" type="submit">
                                            <i class="fa fa-plus"></i><span>Add Field</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="risk">
                            <div class="form-group row justify-content-between my-4">
                                <h6 class="">
                                    <strong>Risk Factor</strong>
                                </h6>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div v-if="riskCapitals.length > 0" class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-stripe">
                                            <thead class="bg-gray-100">
                                            <tr>
                                                <th>Risk Name</th>
                                                <th>Risk Prevention</th>
                                                <th>Remarks</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item,index) in riskCapitals" :key="index">
                                                <td class="text-capitalize">{{ item.risk_name }}</td>
                                                <td class="text-capitalize">{{ item.risk_prevention }}</td>
                                                <td class="text-capitalize">{{ item.risk_remarks }}</td>
                                                <td>
                                                    <button class="btn btn-xs btn-danger rounded-0"
                                                            @click="requestRemoveRiskCapital(item.risk_name,index)">
                                                        <i class="fa fa-remove"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <small class="text-danger">
                                            * {{ maxCount - riskCapitals.length }} risk factor remaining!
                                        </small>
                                    </div>
                                </div>
                            </div>
                            <form v-if="maxCount != riskCapitals.length" data-vv-scope="r_scope"
                                  @submit.prevent="onRiskCapitalSubmit('r_scope')">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="czm-xs">Risk Factor Name <span
                                                class="text-danger">*</span></label>
                                            <div class="input-group input-group-sm">
                                                <input v-model="riskData.risk_name"
                                                       v-validate="'required|name_with_number|min:2|max:100'"
                                                       :class="[(vvErrors.has('r_scope.risk_name') ? 'is-invalid' : '')]"
                                                       class="form-control form-control-sm rounded-0"
                                                       data-vv-as="risk name" data-vv-name="risk_name"
                                                       type="text">
                                                <div v-show="vvErrors.has('r_scope.risk_name')"
                                                     class="invalid-feedback">
                                                    {{ vvErrors.first('r_scope.risk_name') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="mb-0 pl-1 czm-xs">Risk Prevention <span
                                                class="text-danger">*</span></label>
                                            <textarea v-model="riskData.risk_prevention"
                                                      v-validate="'required|name_with_number|max:499'"
                                                      :class="[this.vvErrors.has('r_scope.risk_prevention') ? 'is-invalid' : '']"
                                                      class="form-control rounded-0" data-vv-as="risk prevention"
                                                      data-vv-name="risk_prevention"></textarea>
                                            <div v-show="vvErrors.has('r_scope.risk_prevention')"
                                                 class="invalid-feedback">
                                                {{ vvErrors.first("r_scope.risk_prevention") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="mb-0 pl-1 czm-xs">Remarks(If Any)</label>
                                            <textarea v-model="riskData.risk_remarks"
                                                      v-validate="'name_with_number|max:499'"
                                                      :class="[this.vvErrors.has('r_scope.risk_remarks') ? 'is-invalid' : '']"
                                                      class="form-control rounded-0" data-vv-as="risk_remarks"
                                                      data-vv-name="risk_remarks"></textarea>
                                            <div v-show="vvErrors.has('r_scope.risk_remarks')" class="invalid-feedback">
                                                {{ vvErrors.first("r_scope.risk_remarks") }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <button class="btn btn-brand btn-sm btn-czm-green" type="submit">
                                            <i class="fa fa-plus"></i><span>Add Risk</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="form-group">
                            <button v-if="createView" class="btn btn-sm btn-primary pull-right rounded-0" type="submit"
                                    @click="onSubmit">
                                <i class="fa fa-dot-circle-o"></i>
                                Submit
                            </button>
                            <button v-else class="btn btn-sm btn-primary pull-right rounded-0" type="submit">
                                <i class="fa fa-dot-circle-o"></i>
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="!formView">
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
                            <th>Business Name</th>
                            <th>Business Type</th>
                            <th>Seed Money</th>
                            <th>Status</th>
                            <th class="sort" style="width: 140px" @click="onClickSortItems('created_at')">Created
                            </th>
                            <th style="width: 160px; text-align:center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in outputRes.data" :key="index">
                            <td>{{ sl + index }}</td>
                            <td>{{ item.business_name }}</td>
                            <td>{{ item.j_investment_area ? item.j_investment_area.name : '' }}</td>
                            <td>{{ item.business_seed_money }}</td>
                            <td>
                                <span class='badge badge-success' v-if="'Approved'===item.status">Approved</span>
                                <span class='badge badge-warning' v-else-if="'Pending'===item.status">Pending</span>
                                <span class='badge badge-danger' v-else-if="'Rejected'===item.status">Rejected</span>
                                <span class='badge badge-info' v-else-if="'Hold'===item.status">Hold</span>
                                <span class='badge badge-primary' v-else-if="'Ongoing'===item.status">Ongoing</span>
                                <span class='badge badge-secondary'
                                      v-else-if="'Completed'===item.status">Completed</span>
                                <span class="text-capitalize" v-else>{{ item.status }}</span>
                            </td>
                            <td>{{ item.created_at | dateFormat }}</td>
                            <td>
                                <button class="btn btn-xs btn-github rounded-0" @click="onClickView(item.id)">
                                    <i class="fa fa-eye"></i> View
                                </button>
                                <button class="btn btn-xs btn-danger rounded-0" @click="onClickDelete(item)">
                                    <i class="fa fa-remove"></i> Delete
                                </button>
                            </td>
                        </tr>
                        <tr v-if="outputRes.data.length === 0">
                            <td class="text-center" colspan="8">No Data Found
                            </td>
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
        <!-- Modal -->
        <div id="viewModal" aria-hidden="true" aria-labelledby="viewModalTitle" class="modal fade" role="dialog"
             tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div v-if="chunk" class="modal-content rounded-0">
                    <div class="modal-header">
                        <h6 id="exampleModalCenterTitle" class="modal-title">Business Plan Details</h6>
                        <button aria-label="Close" class="close" data-dismiss="modal" type="button">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm table-hover">
                                        <tr v-if="chunk.business_name">
                                            <td>Business Name</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_name }}</td>
                                        </tr>
                                        <tr v-if="chunk.j_investment_area">
                                            <td>Business Type</td>
                                            <td>:</td>
                                            <td>{{ chunk.j_investment_area.name }}</td>
                                        </tr>
                                        <tr v-if="chunk.is_business_experience">
                                            <td>Business Experience</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_experience_duration }}</td>
                                        </tr>
                                        <tr v-if="chunk.is_business_training">
                                            <td>Training Name</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_training_institute_name }}</td>
                                        </tr>
                                        <tr v-if="chunk.is_business_training">
                                            <td>Training Duration</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_training_duration }}</td>
                                        </tr>
                                        <tr v-if="chunk.business_assist">
                                            <td>Business Assistance</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_assist }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Status</td>
                                            <td>:</td>
                                            <td>
                                                <span class='badge badge-success' v-if="'Approved'===chunk.status">Approved</span>
                                                <span class='badge badge-warning' v-else-if="'Pending'===chunk.status">Pending</span>
                                                <span class='badge badge-danger' v-else-if="'Rejected'===chunk.status">Rejected</span>
                                                <span class='badge badge-info'
                                                      v-else-if="'Hold'===chunk.status">Hold</span>
                                                <span class='badge badge-primary' v-else-if="'Ongoing'===chunk.status">Ongoing</span>
                                                <span class='badge badge-secondary'
                                                      v-else-if="'Completed'===chunk.status">Completed</span>
                                                <span class="text-capitalize" v-else>{{ chunk.status }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Created</td>
                                            <td>:</td>
                                            <td>{{ chunk.created_at | dateFormat }}</td>
                                        </tr>
                                        <tr v-if="chunk.created_user">
                                            <td>Created By</td>
                                            <td>:</td>
                                            <td> {{ chunk.created_user.name }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="table-responsive">
                                    <table class="table table-borderless table-sm table-hover">
                                        <tr v-if="chunk.business_seed_money">
                                            <td style="width: 170px;">Seed Money</td>
                                            <td style="width: 5px;">:</td>
                                            <td>{{ chunk.business_seed_money }}</td>
                                        </tr>
                                        <tr v-if="chunk.possible_gross_income">
                                            <td>Possible Gross Income</td>
                                            <td>:</td>
                                            <td>{{ chunk.possible_gross_income }}</td>
                                        </tr>
                                        <tr v-if="chunk.possible_gross_expense">
                                            <td>Possible Gross Expense</td>
                                            <td>:</td>
                                            <td>{{ chunk.possible_gross_expense }}</td>
                                        </tr>
                                        <tr v-if="chunk.possible_net_profit">
                                            <td>Possible Net Profit</td>
                                            <td>:</td>
                                            <td>{{ chunk.possible_net_profit }}</td>
                                        </tr>
                                        <tr v-if="chunk.business_duration">
                                            <td>Business Duration</td>
                                            <td>:</td>
                                            <td>{{ chunk.business_duration }}</td>
                                        </tr>
                                        <tr v-if="chunk.investment_return_type">
                                            <td>Investment Return Type</td>
                                            <td>:</td>
                                            <td>{{ chunk.investment_return_type }}</td>
                                        </tr>
                                        <tr v-if="chunk.investment_return_amount_each">
                                            <td style="width: 210px;">Investment Each Return Amount</td>
                                            <td>:</td>
                                            <td>{{ chunk.investment_return_amount_each }}
                                            </td>
                                        </tr>
                                        <tr v-if="chunk.updated_user">
                                            <td>Updated By</td>
                                            <td>:</td>
                                            <td> {{ chunk.updated_user.name }}</td>
                                        </tr>
                                        <tr v-if="chunk.updated_user">
                                            <td>Last Updated</td>
                                            <td>:</td>
                                            <td>{{ chunk.updated_at | dateFormat }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div style="font-weight:bold">Capital Partner</div>
                                <div class="customCSS table-responsive border">
                                    <table class="table table-responsive-sm table-sm">
                                        <thead>
                                        <tr>
                                            <th style="width: 250px">Partner Family Name</th>
                                            <th>Amount</th>
                                            <th>Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in chunk.families" :key="index">
                                            <td>{{ item.family ? item.family.name : '' }}</td>
                                            <td>{{ item.amount }}</td>
                                            <td>{{ item.remarks }}</td>
                                        </tr>
                                        <tr v-if="chunk.families.length === 0">
                                            <td class="text-center" colspan="3">No Data Found
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div style="font-weight:bold">Field Capitals</div>
                                <div class="customCSS table-responsive border">
                                    <table class="table table-responsive-sm table-sm">
                                        <thead>
                                        <tr>
                                            <th style="width: 250px">Field Name</th>
                                            <th>Field Unit Price</th>
                                            <th>Field Quantity</th>
                                            <th>Field Total Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in chunk.fields" :key="index">
                                            <td>{{ item.field_name }}</td>
                                            <td><span class="tk">{{ item.field_unit_price }}</span></td>
                                            <td>{{ item.field_quantity }}</td>
                                            <td><span class="tk">{{ item.field_total_price }}</span></td>
                                        </tr>
                                        <tr v-if="chunk.fields.length === 0">
                                            <td class="text-center" colspan="4">No Data Found
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div style="font-weight:bold">Risk Capitals</div>
                                <div class="customCSS table-responsive border">
                                    <table class="table table-responsive-sm table-sm">
                                        <thead>
                                        <tr>
                                            <th style="width: 250px">Risk Name</th>
                                            <th>Risk Prevention</th>
                                            <th>Risk Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in chunk.risks" :key="index">
                                            <td>{{ item.risk_name }}</td>
                                            <td>{{ item.risk_prevention }}</td>
                                            <td>{{ item.risk_remarks }}</td>
                                        </tr>
                                        <tr v-if="chunk.risks.length === 0">
                                            <td class="text-center" colspan="3">No Data Found
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-if="'Pending' !== chunk.meeting_status" class="col-md-12">
                                <div style="font-weight:bold">
                                    Business Plan Details
                                </div>
                                <div class="customCSS table-responsive border">
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                        <tr>
                                            <td>Valid Information:
                                                <span v-if="chunk.is_valid_information"
                                                      class="badge badge-md badge-success">Yes</span>
                                                <span v-else class="badge badge-md badge-danger">No</span>
                                            </td>
                                            <td>Previous Installment:
                                                <span v-if="chunk.is_previous_installment"
                                                      class="badge badge-md badge-success">Yes</span>
                                                <span v-else class="badge badge-md badge-danger">No</span>
                                            </td>
                                            <td>Experience and Skill:
                                                <span v-if="chunk.is_proposed_business_skill_and_experience"
                                                      class="badge badge-md badge-success">Yes</span>
                                                <span v-else class="badge badge-md badge-danger">No</span>
                                            </td>
                                            <td>General Saving:
                                                <span v-if="chunk.is_general_savings"
                                                      class="badge badge-md badge-success">Yes</span>
                                                <span v-else class="badge badge-md badge-danger">No</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Recommended Investment:
                                                <span v-if="chunk.is_recommended" class="badge badge-md badge-success">Yes</span>
                                                <span v-else class="badge badge-md badge-danger">No</span>
                                            </td>
                                            <td style="">Recommendation Remarks:
                                                {{ chunk.recommendation_remarks ? chunk.recommendation_remarks : '' }}
                                            </td>
                                            <td style="">Business Experience Duration:
                                                {{ chunk.business_experience_duration }}
                                            </td>
                                            <td style="">Investment Recieved Date: {{
                                                    chunk.created_at | dateFormat
                                                }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="">Approved Business Area:
                                                {{
                                                    chunk.j_investment_approved_area ?
                                                        chunk.j_investment_approved_area.name : ''
                                                }}
                                            </td>
                                            <td style="">Seed Money: <span v-if="chunk.business_seed_money" class="tk">
                                                {{ chunk.business_seed_money }}</span></td>
                                            <td style="">Seed Duration Monthly:
                                                {{ chunk.business_duration ? chunk.business_duration : '' }}
                                            </td>
                                            <td style="">Possible Gross Income:
                                                <span v-if="chunk.possible_gross_income" class="tk">
                                                    {{ chunk.possible_gross_income }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="">Possible Gross Expense: <span
                                                v-if="chunk.possible_gross_expense"
                                                class="tk">{{ chunk.possible_gross_expense }}</span>
                                            </td>
                                            <td style="">Possible Gross Profit:
                                                <span v-if="chunk.possible_net_profit"
                                                      class="tk">{{
                                                        chunk.possible_net_profit
                                                    }}</span>
                                            </td>
                                            <td style="">Investment Return: {{ chunk.investment_return_type }}</td>
                                            <td style="">Investment Return Amount:
                                                <span v-if="chunk.investment_return_amount_each"
                                                      class="tk">{{ chunk.investment_return_amount_each }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Gro Meeting Date: {{ chunk.meeting_date | dateFormat }}</td>
                                            <td>Gro Meeting Decision:
                                                <span class='badge badge-success'
                                                      v-if="'Approved'===chunk.meeting_status">Approved</span>
                                                <span class='badge badge-warning'
                                                      v-else-if="'Pending'===chunk.meeting_status">Pending</span>
                                                <span class='badge badge-danger'
                                                      v-else-if="'Rejected'===chunk.meeting_status">Rejected</span>
                                                <span class='badge badge-info'
                                                      v-else-if="'Hold'===chunk.meeting_status">Hold</span>
                                                <span class="text-capitalize" v-else>{{ chunk.meeting_status }}</span>
                                            </td>
                                            <td>File:
                                                <a v-if="chunk.file" :href="chunk.file_path" :text="chunk.file"
                                                   class="btn btn-xs btn-spotify mx-2" target="_blank"
                                                   type="button" @click:prevent="downloadItem(formData)">
                                                    <i class="fa fa-arrow-circle-down"></i><span>&nbsp;Download</span>
                                                </a>
                                                <button v-else class="btn btn-xs btn-danger mx-2">No File</button>
                                            </td>
                                            <td>Gro Remarks: {{ chunk.gro_remarks }}</td>
                                        </tr>
                                        <tr>
                                            <td>Disbursement Date: {{ chunk.disbursement_date | dateFormat }}</td>
                                            <td>Disbursement Amount:<span v-if="chunk.disbursement_amount" class="tk">{{
                                                    chunk.disbursement_amount
                                                }}</span>
                                            </td>
                                            <td>Approved Amount: <span v-if="chunk.approved_amount"
                                                                       class="tk">{{ chunk.approved_amount }}</span>
                                            </td>
                                            <td>Business Assist By: {{ chunk.business_assist }}</td>
                                        </tr>
                                        <tr>
                                            <td>Approved By: {{ chunk.approved_by ? chunk.approved_by.name : '' }}</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-brand btn-sm rounded-0" data-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Pagination from "../../../Pagination.vue";
import queryString from "query-string";

export default {
    name: "BusinessPlanJoint",
    components: {Pagination},
    data() {
        return {
            loading: false,
            createView: true,
            formView: false,
            timeout: null,
            errorHtml: "",
            errors: {},
            maxCount: 5,
            sl: 1,
            totalSourceCapital: 0,
            totalFieldCapital: 0,
            search: {
                page: 1,
                sort: "created_at",
                type: "desc",
                query: "",
                item: "",
            },
            formData: {
                business_name: "",
                j_investment_area_id: "",
                business_duration: "",
                business_seed_money: "",
                possible_gross_income: "",
                possible_gross_expense: "",
                investment_return_type: "",
                investment_return_amount_each: "",
                is_business_experience: "false",
                business_experience_duration: "",
                is_business_training: "false",
                business_training_duration: "",
                business_training_institute_name: "",
            },
            sourceData: {
                partner_id: "",
                source_amount: "",
                source_remarks: "",
            },
            fieldData: {
                field_name: "",
                field_unit_price: "",
                field_quantity: "",
            },
            riskData: {
                risk_name: "",
                risk_prevention: "",
                risk_remarks: "",
            },
            // init data
            statuses: [],
            meetingStatuses: [],
            families: [],
            investmentReturnTypes: [],
            investmentAreas: [],
            sourceCapitalTypes: [],
            fieldCapitalTypes: [],
            // array
            selectedPartnerIds: [],
            sourceCapitals: [],
            fieldCapitals: [],
            riskCapitals: [],
            outputRes: {
                data: [],
            },
            chunk: {
                families: [],
                fields: [],
                risks: [],
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
        paginationClicked(page) {
            this.updateQueryParams("page", page);
            this.search.page = page;
            this.getAll();
        },
        updateQueryParams(key, value) {
            let parsed = queryString.parse(location.search);
            let page = key == "page" ? value : !!parsed.page ? parsed.page : 1;
            let sort =
                key == "sort" ? value : !!parsed.sort ? parsed.sort : "created_at";
            let type = key == "type" ? value : !!parsed.type ? parsed.type : "desc";
            let query = key == "query" ? value : !!parsed.query ? parsed.query : "";
            let item = key == "item" ? value : !!parsed.item ? parsed.item : 25;
            let queryStringify = queryString.stringify({
                page,
                sort,
                type,
                query,
                item,
            });
            let newUrl = this.routes.one + "?" + queryStringify;
            window.history.pushState({}, null, newUrl);
        },
        itemPerPageSelect() {
            this.search.page = 1;
            this.updateQueryParams("page", this.search.page);
            this.updateQueryParams("item", this.search.item);
            this.getAll();
        },
        onClickSortItems(key) {
            let _this = this;
            _this.search.sort = key;
            if (_this.search.type == "asc") {
                _this.search.type = "desc";
            } else {
                _this.search.type = "asc";
            }
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
        onSubmit() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result && _this.createView) {
                    _this.onNewAdd();
                } else if (result && !_this.createView) {
                    // _this.onUpdate();
                }
            });
        },
        onNewAdd() {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            _this.errorHtml = "";
            _this.formData["sourceCapitals"] = _this.sourceCapitals;
            _this.formData["fieldCapitals"] = _this.fieldCapitals;
            _this.formData["riskCapitals"] = _this.riskCapitals;
            axios.post(_this.routes.one, _this.formData).then((res) => {
                if (res.data.success) {
                    toastr.success(res.data.success, "Success");
                    _this.getAll();
                } else {
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((error) => {
                if (error.response) {
                    toastr.error(error.response.data.message, "Error");
                    if (error.response && error.response.data.errors) {
                        _this.$setErrorsFromLaravel(
                            error.response.data
                        );
                        _this.errors = error.response.data.errors;
                        _this.objToString(_this.errors);
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        onSourceCapitalSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addSourceCapital();
                }
                /*else {
                    _this.errors = _this.vvErrors.collect();
                }*/
            });
        },
        addSourceCapital() {
            let _this = this;
            _this.selectedPartnerIds.push(_this.sourceData.partner_id);
            _this.sourceCapitals.push(_this.sourceData);
            _this.countSourceCapital();
            _this.sourceData = {};
            _this.sourceData.partner_id = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
        getFamilyName(id) {
            return this.families.find(item => item.id == id).name;
        },
        requestRemoveSourceCapital(item, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html: '<p style="color:#3085d6">"' + _this.getFamilyName(item) + '"</p>' + "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeSourceCapital(index);
                }
            });
        },
        removeSourceCapital(index) {
            let _this = this;
            _this.selectedPartnerIds.splice(index, 1)
            _this.sourceCapitals.splice(index, 1);
            _this.countSourceCapital();
        },
        countSourceCapital() {
            let _this = this;
            _this.totalSourceCapital = 0;
            if (_this.sourceCapitals.length > 0) {
                _this.sourceCapitals.forEach((item) => {
                    _this.totalSourceCapital += item.source_amount;
                });
            }
        },
        onRiskCapitalSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addRiskCapital();
                }
                /*else {
                    _this.errors = _this.vvErrors.collect();
                }*/
            });
        },
        addRiskCapital() {
            let _this = this;
            _this.riskCapitals.push(_this.riskData);
            _this.riskData = {};
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
        requestRemoveRiskCapital(item, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    item +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeRiskCapital(index);
                }
            });
        },
        removeRiskCapital(index) {
            let _this = this;
            _this.riskCapitals.splice(index, 1);
        },
        onFieldCapitalSubmit(scope) {
            let _this = this;
            _this.$validator.validateAll(scope).then((result) => {
                if (result) {
                    _this.addFieldCapital();
                }
                /*else {
                    _this.errors = _this.vvErrors.collect();
                }*/
            });
        },
        addFieldCapital() {
            let _this = this;
            _this.fieldCapitals.push(_this.fieldData);
            _this.countFieldCapital();
            _this.fieldData = {};
            _this.fieldData.field_name = "";
            _this.$nextTick(() => {
                _this.$validator.reset();
            });
        },
        requestRemoveFieldCapital(item, index) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    item +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, Remove it!",
            }).then((result) => {
                if (result.value) {
                    _this.removeFieldCapital(index);
                }
            });
        },
        removeFieldCapital(index) {
            let _this = this;
            _this.fieldCapitals.splice(index, 1);
            _this.countFieldCapital();
        },
        countFieldCapital() {
            let _this = this;
            _this.totalfieldCapitals = 0;
            if (_this.fieldCapitals.length > 0) {
                _this.fieldCapitals.forEach((item) => {
                    _this.totalFieldCapital +=
                        item.field_unit_price * item.field_quantity;
                });
            }
        },
        getAll() {
            let _this = this;
            _this.formView = false;
            _this.loading = true;
            _this.createView = true;
            this.$validator.reset();
            axios.post(_this.routes.list, _this.search).then((res) => {
                if (res.data) {
                    _this.selectedPartnerIds = [];
                    _this.outputRes = res.data.lists;
                    _this.statuses = res.data.statuses;
                    _this.meetingStatuses = res.data.meetingStatuses;
                    _this.families = res.data.families;
                    _this.investmentAreas = res.data.investmentAreas;
                    _this.investmentReturnTypes = res.data.investmentReturnTypes;
                    _this.sourceCapitalTypes = res.data.sourceCapitalTypes;
                    _this.fieldCapitalTypes = res.data.fieldCapitalTypes;
                    if (_this.search.page > 1) {
                        _this.sl =
                            (_this.search.page - 1) * parseInt(_this.outputRes.per_page) +
                            1;
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
                        _this.$setErrorsFromLaravel(
                            error.response.data
                        );
                    }
                } else {
                    toastr.error(error.message, "Error");
                }
                _this.loading = false;
            });
        },
        addNew() {
            let _this = this;
            _this.formData.business_name = "";
            _this.formData.j_investment_area_id = "";
            _this.formData.business_duration = "";
            _this.formData.business_seed_money = "";
            _this.formData.possible_gross_income = "";
            _this.formData.possible_gross_expense = "";
            _this.formData.investment_return_type = "";
            _this.formData.investment_return_amount_each = "";
            _this.formData.is_business_experience = "false";
            _this.formData.business_experience_duration = "";
            _this.formData.is_business_training = "false";
            _this.formData.business_training_duration = "";
            _this.formData.business_training_institute_name = "";
            _this.sourceCapitals = [];
            _this.fieldCapitals = [];
            _this.riskCapitals = [];
            _this.totalSourceCapital = 0;
            _this.totalFieldCapital = 0;
            _this.formView = true;
            _this.errors = {};
            this.$validator.reset();
        },
        onClickDelete(item) {
            let _this = this;
            Swal.fire({
                title: "Are you sure?",
                html:
                    '<p style="color:#3085d6">"' +
                    item.business_name +
                    '"</p>' +
                    "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.value) {
                    _this.onDeleteRequest(item.id);
                }
            });
        },
        onDeleteRequest(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios
                .delete(_this.routes.one + "/" + id)
                .then((res) => {
                    if (res.data.success) {
                        Swal.fire("Deleted!", res.data.success, "success");
                        _this.getAll();
                    } else {
                        toastr.error(res.data.message, "Warning");
                    }
                    _this.loading = false;
                })
                .catch((error) => {
                    if (error.response) {
                        toastr.error(error.response.data.message, "Error");
                        if (error.response && error.response.data.errors) {
                            _this.$setErrorsFromLaravel(
                                error.response.data
                            );
                        }
                    } else {
                        toastr.error(error.message, "Error");
                    }
                    _this.loading = false;
                });
        },
        onClickView(id) {
            let _this = this;
            _this.loading = true;
            _this.errors = {};
            axios.patch(_this.routes.one + "/" + id).then((res) => {
                if (res.data) {
                    _this.chunk = res.data;
                    $("#viewModal").modal({show: true, backdrop: "static"});
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
        this.search.sort = !!parsed.sort ? parsed.sort : "created_at";
        this.search.type = !!parsed.type ? parsed.type : "desc";
        this.search.query = !!parsed.query ? parsed.query : "";
        this.search.item = !!parsed.item ? parsed.item : 25;
        this.getAll();
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
.customCSS table th td tr {
    border: none;
}

.customCSS th {
    border: none;
}

.customCSS td {
    border: none;
}

.customCSS tr {
    border: none;
}

.customCSS th {
    font-weight: normal;
    text-decoration: underline;
}
</style>

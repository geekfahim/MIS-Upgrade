<template>
    <div>
        <div v-if="$parent.formData.mustahiqs.length > 0" class="table-responsive-sm">
            <table class="table table-sm table-stripe">
                <thead class="bg-gray-100">
                <tr>
                    <th>Mustahiq Name</th>
                    <th>Gender</th>
                    <th>Birthday/Age</th>
                    <th>Relation</th>
                    <th>Religion</th>
                    <th style="width: 160px; text-align: center">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item,index) in $parent.formData.mustahiqs" :key=index>
                    <td>{{ item.name }}</td>
                    <td>{{ item.gender }}</td>
                    <td>
                        <span v-if="item.age">{{ item.age }}</span>
                        <span v-if="item.birth_date">{{ item.birth_date | dateFormat }}</span>
                    </td>
                    <td>{{ item.relation_with_family_head }}</td>
                    <td>{{ item.religion }}</td>
                    <td>
                        <button class="btn btn-xs btn-danger rounded-0" @click="removeMustahiq(item,index)">
                            <i class="fa fa-remove"></i> Remove Mustahiq
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="row no-gutters">
            <div class="col-md-3">
                <div class="p-1">
                    <div class="card-header p-1">
                        Mustahiq's Picture (max:150kb)
                        <span class="card-header-actions pr-1">
						<button
                            class="btn btn-danger btn-xs"
                            @click="removePicture()"> Remove
						</button>
					</span>
                    </div>
                    <div class="border w-100" style="height: 230px" @click="chooseFilePicture()">
                        <img :src="picturePreview" style="
							display: block;
							width: 80%;
							margin: 2px auto;
							max-height: 220px;
							overflow: hidden;
						"/>
                    </div>
                    <input id="fileUploadPicture" accept="image/*" hidden type="file" @change="onFileChangePicture"/>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1 mr-4">Avail to Earn </label>
                        <div class="form-check form-check-inline">
                            <input id="is_earn_ability_true" v-model.number="formData.is_earn_ability"
                                   class="form-check-input"
                                   name="is_earn_ability" type="radio" value="1"/>
                            <label class="form-check-label" for="is_earn_ability_true">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="is_earn_ability_false" v-model.number="formData.is_earn_ability"
                                   class="form-check-input"
                                   name="is_earn_ability" type="radio" value="0"/>
                            <label class="form-check-label" for="is_earn_ability_false">No</label>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Vocational Trainings Have</label>
                        <Select2 v-model="formData.vocational_haves"
                                 :options="$parent.initData.vocationals"
                                 :settings="{ width: '100%', allowClear: true, multiple: true }"
                                 data-vv-as="vocational trainings have"
                                 data-vv-name="vocational_haves"/>
                        <div v-if="vvErrors.has('vocational_haves')"
                             :class="[(vvErrors.has('vocational_haves') ? ' d-block' : '')]"
                             class="invalid-feedback">
                            {{ vvErrors.first('vocational_haves') }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Vocational Trainings Need</label>
                        <Select2 v-model="formData.vocational_needs"
                                 :options="$parent.initData.vocationals"
                                 :settings="{ width: '100%', allowClear: true, multiple: true }"
                                 data-vv-as="vocational trainings need"
                                 data-vv-name="vocational_needs"/>
                        <div v-if="vvErrors.has('vocational_needs')"
                             :class="[(vvErrors.has('vocational_needs') ? ' d-block' : '')]"
                             class="invalid-feedback">
                            {{ vvErrors.first('vocational_needs') }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Skill Trainings Have</label>
                        <Select2 v-model="formData.skill_haves"
                                 :options="$parent.initData.skills"
                                 :settings="{ width: '100%', allowClear: true, multiple: true }"
                                 data-vv-as="skill trainings have"
                                 data-vv-name="skill_haves"/>
                        <div v-if="vvErrors.has('skill_haves')"
                             :class="[(vvErrors.has('skill_haves') ? ' d-block' : '')]"
                             class="invalid-feedback">
                            {{ vvErrors.first('skill_haves') }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Skill Trainings Need</label>
                        <Select2 v-model="formData.skill_needs"
                                 :options="$parent.initData.skills"
                                 :settings="{ width: '100%', allowClear: true, multiple: true }"
                                 data-vv-as="skill trainings need"
                                 data-vv-name="skill_needs"/>
                        <div v-if="vvErrors.has('skill_needs')"
                             :class="[(vvErrors.has('skill_needs') ? ' d-block' : '')]"
                             class="invalid-feedback">
                            {{ vvErrors.first('skill_needs') }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Marital Status</label>
                        <select v-model.number="formData.marital_status"
                                :class="[this.vvErrors.has('marital_status') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="marital status" data-vv-name="marital_status">
                            <option v-for="(item,index) in $parent.initData.maritalStatuses" :key="index"
                                    :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('marital_status')" class="invalid-feedback">
                            {{ vvErrors.first("marital_status") }}
                        </div>
                    </div>
                </div>
                <div v-show="'Unmarried'!==formData.marital_status">
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Spouse Name </label>
                            <div class="input-group">
                                <input v-model="formData.spouse_name" v-validate="'max:31'"
                                       :class="[this.vvErrors.has('spouse_name') ? 'is-invalid' : '']"
                                       class="form-control rounded-0"
                                       data-vv-as="Spouse Name" data-vv-name="spouse_name" type="text"/>
                                <div v-show="vvErrors.has('spouse_name')" class="invalid-feedback">
                                    {{ vvErrors.first("spouse_name") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Spouse Living Status</label>
                            <div class="form-check form-check-inline">
                                <select v-model.number="formData.spouse_living_status"
                                        :class="[this.vvErrors.has('spouse_living_status') ? 'is-invalid' : '']"
                                        class="form-control form-control-sm rounded-0" data-vv-as="spouse living status"
                                        data-vv-name="spouse_living_status">
                                    <option v-for="(item,index) in $parent.initData.relationalLivingStatus" :key="index"
                                            :value="item">
                                        {{ item }}
                                    </option>
                                </select>
                                <div v-show="vvErrors.has('spouse_living_status')" class="invalid-feedback">
                                    {{ vvErrors.first("spouse_living_status") }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Spouse Mobile</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">+880</span>
                                </div>
                                <input v-model.number="formData.spouse_mobile" v-validate="'numeric|mobile'"
                                       :class="[this.vvErrors.has('spouse_mobile') ? 'is-invalid' : '']"
                                       class="form-control rounded-0"
                                       data-vv-as="spouse mobile" data-vv-name="spouse_mobile" type="text"/>
                                <div v-show="vvErrors.has('spouse_mobile')" class="invalid-feedback">
                                    {{ vvErrors.first("spouse_mobile") }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="czm-xs mb-0 pl-1">Highest Education</label>
                        <select v-model.number="formData.highest_education_level"
                                :class="[this.vvErrors.has('highest_education_level') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Highest Education"
                                data-vv-name="highest_education_level">
                            <option v-for="(item,index) in $parent.initData.educationLevels" :key="index"
                                    :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('highest_education_level')" class="invalid-feedback">
                            {{ vvErrors.first("highest_education_level") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Blood Group</label>
                        <select v-model.number="formData.blood_group"
                                :class="[this.vvErrors.has('blood_group') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Blood Group"
                                data-vv-name="blood_group">
                            <option v-for="(item,index) in $parent.initData.bloodGroups" :key="index" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('blood_group')" class="invalid-feedback">
                            {{ vvErrors.first("blood_group") }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Full Name(As Certificate)<span
                            class="text-danger">*</span></label>
                        <input v-model="formData.name" v-validate="'required|name_with_number|min:2|max:50'"
                               :class="[this.vvErrors.has('name') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0"
                               data-vv-as="full name" data-vv-name="name" type="text"/>
                        <div v-show="vvErrors.has('name')" class="invalid-feedback">
                            {{ vvErrors.first("name") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Gender<span class="text-danger">*</span></label>
                        <select v-model.number="formData.gender" v-validate="'required'"
                                :class="[this.vvErrors.has('gender') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Gender"
                                data-vv-name="gender">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.genders" :key="index" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('gender')" class="invalid-feedback">
                            {{ vvErrors.first("gender") }}
                        </div>
                    </div>
                </div>
                <div v-show="'Female' === formData.gender && 'Unmarried' !== formData.marital_status"
                     class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Pregnancy Status</label>
                        <select v-model.number="formData.pregnancy_status" v-validate="'required'"
                                :class="[this.vvErrors.has('pregnancy_status') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Gender"
                                data-vv-name="pregnancy_status">
                            <option v-for="(item,index) in $parent.initData.pregnancyStatuses" :key="item"
                                    :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('pregnancy_status')" class="invalid-feedback">
                            {{ vvErrors.first("pregnancy_status") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <div class="form-check form-check-inline">
                            <input id="inlineRadio3" ref="birthAndAge" v-model.number="formData.is_birth_date"
                                   class="form-check-input" name="inlineRadioOptions1" type="radio" value="1"
                                   @change="checkBirthDate"/>
                            <label class="form-check-label" for="inlineRadio3">Date of Birth<span
                                class="text-danger">*</span></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="inlineRadio4" v-model.number="formData.is_birth_date" class="form-check-input"
                                   name="inlineRadioOptions1" type="radio" value="0" @change="checkBirthDate"/>
                            <label class="form-check-label" for="inlineRadio4">Age<span
                                class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="row no-gutters p-1">
                    <div class="col-md-6">
                        <input id="birth_date" v-model="formData.birth_date"
                               v-validate="'required_if:birthAndAge,1|date_format:yyyy-mm-dd'"
                               :class="[this.vvErrors.has('birth_date') ? 'is-invalid' : '']"
                               :disabled="0===formData.is_birth_date" autocomplete="off"
                               class="form-control form-control-sm rounded-0 datepicker" data-vv-as="date of birth"
                               data-vv-name="birth_date" name="birth_date" type="text"/>
                        <div v-show="vvErrors.has('birth_date')" class="invalid-feedback">
                            {{ vvErrors.first("birth_date") }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input id="age" v-model.number="formData.age"
                               v-validate="'required_if:birthAndAge,0|numeric|max_value:150'"
                               :class="[this.vvErrors.has('age') ? 'is-invalid' : '']"
                               :disabled="1===formData.is_birth_date"
                               class="form-control form-control-sm rounded-0"
                               data-vv-as="Age" data-vv-name="age" name="age"
                               type="number"/>
                        <div v-show="vvErrors.has('age')" class="invalid-feedback">
                            {{ vvErrors.first("age") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Religion<span class="text-danger">*</span></label>
                        <select v-model.number="formData.religion" v-validate="'required'"
                                :class="[this.vvErrors.has('religion') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Religion"
                                data-vv-name="religion">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.religions" :key="index" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('religion')" class="invalid-feedback">
                            {{ vvErrors.first("religion") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1 mr-4">Is Orphan ?</label>
                        <div class="form-check form-check-inline">
                            <input id="is_orphan_true" v-model.number="formData.is_orphan" class="form-check-input"
                                   name="is_orphan" type="radio" value="1"/>
                            <label class="form-check-label" for="is_orphan_true">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="is_orphan_false" v-model.number="formData.is_orphan" class="form-check-input"
                                   name="is_orphan" type="radio" value="0"/>
                            <label class="form-check-label" for="is_orphan_false">No</label>
                        </div>
                    </div>
                </div>
                <div v-show="formData.is_orphan" class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Orphan Type</label>
                        <select v-model.number="formData.orphan_type"
                                :class="[this.vvErrors.has('orphan_type') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="orphan type"
                                data-vv-name="orphan_type">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.orphanTypes" :key="index" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('orphan_type')" class="invalid-feedback">
                            {{ vvErrors.first("orphan_type") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Mobile</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input v-model.number="formData.mobile" v-validate="'numeric|mobile'"
                                   :class="[this.vvErrors.has('mobile') ? 'is-invalid' : '']"
                                   class="form-control rounded-0"
                                   data-vv-as="mobile" data-vv-name="mobile" type="text"/>
                            <div v-show="vvErrors.has('mobile')" class="invalid-feedback">
                                {{ vvErrors.first("mobile") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Alternative Mobile Number (If Any)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input v-model.number="formData.alternate_mobile" v-validate="'numeric|mobile'"
                                   :class="[this.vvErrors.has('alternate_mobile') ? 'is-invalid' : '']"
                                   class="form-control rounded-0" data-vv-as="Alternative Mobile"
                                   data-vv-name="alternate_mobile" type="text"/>
                            <div v-show="vvErrors.has('alternate_mobile')" class="invalid-feedback">
                                {{ vvErrors.first("alternate_mobile") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Emergency Mobile Number (If Any)</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input v-model.number="formData.emergency_mobile" v-validate="'numeric|mobile'"
                                   :class="[this.vvErrors.has('emergency_mobile') ? 'is-invalid' : '']"
                                   class="form-control rounded-0" data-vv-as="emergency mobile"
                                   data-vv-name="emergency_mobile" type="text"/>
                            <div v-show="vvErrors.has('emergency_mobile')" class="invalid-feedback">
                                {{ vvErrors.first("emergency_mobile") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Email</label>
                        <input v-model="formData.email" v-validate="'email|min:5|max:30'"
                               :class="[this.vvErrors.has('email') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Email" data-vv-name="email"
                               type="email"/>
                        <div v-show="vvErrors.has('email')" class="invalid-feedback">
                            {{ vvErrors.first("email") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's National Id Number</label>
                        <input v-model="formData.nid" v-validate="'alpha_num|min:5|max:20'"
                               :class="[this.vvErrors.has('nid') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="National Id Number"
                               data-vv-name="nid" type="text"/>
                        <div v-show="vvErrors.has('nid')" class="invalid-feedback">
                            {{ vvErrors.first("nid") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Passport Number</label>
                        <input v-model="formData.passport" v-validate="'alpha_num|min:5|max:20'"
                               :class="[this.vvErrors.has('passport') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Passport"
                               data-vv-name="passport"
                               type="text"/>
                        <div v-show="vvErrors.has('passport')" class="invalid-feedback">
                            {{ vvErrors.first("passport") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Birth Certificate Number</label>
                        <input v-model="formData.birth_certificate" v-validate="'alpha_num|min:5|max:20'"
                               :class="[this.vvErrors.has('birth_certificate') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Birth Certificate Number"
                               data-vv-name="birth_certificate" type="text"/>
                        <div v-show="vvErrors.has('birth_certificate')" class="invalid-feedback">
                            {{ vvErrors.first("birth_certificate") }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Relation with Family Head<span class="text-danger">*</span></label>
                        <select v-model.number="formData.relation_with_family_head" v-validate="'required'"
                                :class="[this.vvErrors.has('relation_with_family_head') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Relation with Family Head"
                                data-vv-name="relation_with_family_head">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in computeRelations" :key="index" :value="item">
                                {{ item }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('relation_with_family_head')" class="invalid-feedback">
                            {{ vvErrors.first("relation_with_family_head") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq's Reference Number</label>
                        <input v-model="formData.reference_number" v-validate="'alpha_num|min:2|max:50'"
                               :class="[this.vvErrors.has('reference_number') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Reference Number"
                               data-vv-name="reference_number" type="text"/>
                        <div v-show="vvErrors.has('reference_number')" class="invalid-feedback">
                            {{ vvErrors.first("reference_number") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Father's Name</label>
                        <input v-model="formData.father_name" v-validate="'min:2|max:50'"
                               :class="[this.vvErrors.has('father_name') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Father's Name"
                               data-vv-name="father_name" type="text"/>
                        <div v-show="vvErrors.has('father_name')" class="invalid-feedback">
                            {{ vvErrors.first("father_name") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Father Living Status</label>
                        <div class="form-check form-check-inline">
                            <select v-model.number="formData.father_living_status"
                                    :class="[this.vvErrors.has('father_living_status') ? 'is-invalid' : '']"
                                    class="form-control form-control-sm rounded-0" data-vv-as="spouse living status"
                                    data-vv-name="spouse_living_status">
                                <option v-for="(item,index) in $parent.initData.relationalLivingStatus" :key="index"
                                        :value="item">
                                    {{ item }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Father Mobile</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input v-model.number="formData.father_mobile" v-validate="'numeric|mobile'"
                                   :class="[this.vvErrors.has('father_mobile') ? 'is-invalid' : '']"
                                   class="form-control rounded-0"
                                   data-vv-as="father mobile" data-vv-name="father_mobile" type="text"/>
                            <div v-show="vvErrors.has('father_mobile')" class="invalid-feedback">
                                {{ vvErrors.first("father_mobile") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mother's Name</label>
                        <input v-model="formData.mother_name" v-validate="'min:2|max:50'"
                               :class="[this.vvErrors.has('mother_name') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Mother's Name"
                               data-vv-name="mother_name" type="text"/>
                        <div v-show="vvErrors.has('mother_name')" class="invalid-feedback">
                            {{ vvErrors.first("mother_name") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mother Living Status</label>
                        <div class="form-check form-check-inline">
                            <select v-model.number="formData.mother_living_status"
                                    :class="[this.vvErrors.has('mother_living_status') ? 'is-invalid' : '']"
                                    class="form-control form-control-sm rounded-0" data-vv-as="spouse living status"
                                    data-vv-name="spouse_living_status">
                                <option v-for="(item,index) in $parent.initData.relationalLivingStatus" :key="index"
                                        :value="item">
                                    {{ item }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mother Mobile</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+880</span>
                            </div>
                            <input v-model.number="formData.mother_mobile" v-validate="'numeric|mobile'"
                                   :class="[this.vvErrors.has('mother_mobile') ? 'is-invalid' : '']"
                                   class="form-control rounded-0"
                                   data-vv-as="mother mobile" data-vv-name="mother_mobile" type="text"/>
                            <div v-show="vvErrors.has('mother_mobile')" class="invalid-feedback">
                                {{ vvErrors.first("mother_mobile") }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq Occupation</label>
                        <select v-model.number="formData.occupation_id"
                                :class="[this.vvErrors.has('occupation_id') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="occupation"
                                data-vv-name="occupation_id">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.occupations" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('occupation_id')" class="invalid-feedback">
                            {{ vvErrors.first("occupation_id") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Mustahiq Monthly Income (Average)</label>
                        <input v-model.number="formData.monthly_income"
                               v-validate="'numeric|min:2|max:10|max_value:2000000000'"
                               :class="[this.vvErrors.has('monthly_income') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Monthly Income"
                               data-vv-name="monthly_income" type="text"/>
                        <div v-show="vvErrors.has('monthly_income')" class="invalid-feedback">
                            {{ vvErrors.first("monthly_income") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Any Major Disease</label>
                        <div class="form-check form-check-inline">
                            <input id="healthRadioOptionsYes" v-model.number="formData.is_disease"
                                   class="form-check-input"
                                   name="healthRadioOptions" type="radio" value="1"/>
                            <label class="form-check-label" for="healthRadioOptionsYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="healthRadioOptionsNo" v-model.number="formData.is_disease"
                                   class="form-check-input"
                                   name="healthRadioOptions" type="radio" value="0"/>
                            <label class="form-check-label" for="healthRadioOptionsNo">No</label>
                        </div>
                    </div>
                </div>
                <div v-show="formData.is_disease" class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Disease Type</label>
                        <select v-model.number="formData.disease_id"
                                :class="[this.vvErrors.has('disease_id') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Disease Type"
                                data-vv-name="disease_id">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.diseases" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('disease_id')" class="invalid-feedback">
                            {{ vvErrors.first("disease_id") }}
                        </div>
                    </div>
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Regular Medicine</label>
                        <div class="form-check form-check-inline">
                            <input id="is_disease_regular_medicine_true"
                                   v-model.number="formData.is_disease_regular_medicine" class="form-check-input"
                                   name="is_disease_regular_medicine" type="radio" value="1"/>
                            <label class="form-check-label" for="is_disease_regular_medicine_true">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="is_disease_regular_medicine_false"
                                   v-model.number="formData.is_disease_regular_medicine" class="form-check-input"
                                   name="is_disease_regular_medicine" type="radio" value="0"/>
                            <label class="form-check-label" for="is_disease_regular_medicine_false">No</label>
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Remarks (If Any)</label>
                        <textarea v-model="formData.remarks" v-validate="'max:100'"
                                  :class="[this.vvErrors.has('remarks') ? 'is-invalid' : '']"
                                  class="form-control rounded-0"
                                  data-vv-as="remarks" data-vv-name="remarks"></textarea>
                        <div v-show="vvErrors.has('remarks')" class="invalid-feedback">
                            {{ vvErrors.first("remarks") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1 mr-4">Disability</label>
                        <div class="form-check form-check-inline">
                            <input id="inlineRadio1" v-model.number="formData.is_disability" class="form-check-input"
                                   name="inlineRadioOptions" type="radio" value="1"/>
                            <label class="form-check-label" for="inlineRadio1">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="inlineRadio2" v-model.number="formData.is_disability" class="form-check-input"
                                   name="inlineRadioOptions" type="radio" value="0"/>
                            <label class="form-check-label" for="inlineRadio2">No</label>
                        </div>
                    </div>
                </div>
                <div v-show="formData.is_disability" class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Disability Type</label>
                        <select v-model.number="formData.disability_id"
                                :class="[this.vvErrors.has('disability_id') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Disability Type"
                                data-vv-name="disability_id">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.disabilities" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('disability_id')" class="invalid-feedback">
                            {{ vvErrors.first("disability_id") }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Present Address</label>
                        <textarea v-model="formData.present_address" v-validate="'max:100'"
                                  :class="[this.vvErrors.has('present_address') ? 'is-invalid' : '']"
                                  class="form-control rounded-0" data-vv-as="Present Address"
                                  data-vv-name="present_address"></textarea>
                        <div v-show="vvErrors.has('present_address')" class="invalid-feedback">
                            {{ vvErrors.first("present_address") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Present District</label>
                        <select v-model.number="formData.present_district_id"
                                :class="[this.vvErrors.has('present_district_id') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Present District"
                                data-vv-name="present_district_id" @change="getUpazila('present')">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.districts" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('present_district_id')" class="invalid-feedback">
                            {{ vvErrors.first("present_district_id") }}
                        </div>
                    </div>
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Present Upazila / Thana</label>
                        <select v-model.number="formData.present_upazila_id"
                                :class="[this.vvErrors.has('present_upazila_id') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Present District"
                                data-vv-name="present_upazila_id" @change="getUnion('present')">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in presentUpazilas" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('present_upazila_id')" class="invalid-feedback">
                            {{ vvErrors.first("present_upazila_id") }}
                        </div>
                    </div>
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Present Union / City</label>
                        <select v-model.number="formData.present_union_id"
                                :class="[this.vvErrors.has('present_union_id') ? 'is-invalid' : '']"
                                class="form-control form-control-sm rounded-0" data-vv-as="Present District"
                                data-vv-name="present_union_id">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in presentUnions" :key="index" :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                        <div v-show="vvErrors.has('present_union_id')" class="invalid-feedback">
                            {{ vvErrors.first("present_union_id") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1">Present Postal Code</label>
                        <input v-model.number="formData.present_post_code" v-validate="'numeric|min:2|max:6'"
                               :class="[this.vvErrors.has('present_post_code') ? 'is-invalid' : '']"
                               class="form-control form-control-sm rounded-0" data-vv-as="Present Post Code"
                               data-vv-name="present_post_code" type="text"/>
                        <div v-show="vvErrors.has('present_post_code')" class="invalid-feedback">
                            {{ vvErrors.first("present_post_code") }}
                        </div>
                    </div>
                </div>
                <div class="p-1">
                    <div class="bg-gray-100">
                        <label class="mb-0 pl-1 mr-4">Permanent Address (same as present)</label> <br>
                        <div class="form-check form-check-inline">
                            <input id="addressRadioOptionsYes" v-model.number="formData.is_permanent_as_present"
                                   class="form-check-input" name="addressRadioOptions" type="radio" value="1"
                                   @change="checkAddress"/>
                            <label class="form-check-label" for="addressRadioOptionsYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input id="addressRadioOptionsNo" v-model.number="formData.is_permanent_as_present"
                                   class="form-check-input" name="addressRadioOptions" type="radio" value="0"
                                   @change="checkAddress"/>
                            <label class="form-check-label" for="addressRadioOptionsNo">No</label>
                        </div>
                    </div>
                </div>
                <div v-if="!formData.is_permanent_as_present">
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Permanent Address</label>
                            <textarea v-model="formData.permanent_address" v-validate="'max:100'"
                                      :class="[this.vvErrors.has('permanent_address') ? 'is-invalid' : '']"
                                      class="form-control rounded-0" data-vv-as="Permanent Address"
                                      data-vv-name="permanent_address"></textarea>
                            <div v-show="vvErrors.has('permanent_address')" class="invalid-feedback">
                                {{ vvErrors.first("permanent_address") }}
                            </div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Permanent District</label>
                            <select v-model.number="formData.permanent_district_id"
                                    :class="[this.vvErrors.has('permanent_district_id') ? 'is-invalid' : '']"
                                    class="form-control form-control-sm rounded-0" data-vv-as="Permanent District"
                                    data-vv-name="permanent_district_id" @change="getUpazila('permanent')">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in $parent.initData.districts" :key="index"
                                        :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('permanent_district_id')" class="invalid-feedback">
                                {{ vvErrors.first("permanent_district_id") }}
                            </div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Permanent Upazila / City</label>
                            <select v-model.number="formData.permanent_upazila_id"
                                    :class="[this.vvErrors.has('permanent_upazila_id') ? 'is-invalid' : '']"
                                    class="form-control form-control-sm rounded-0" data-vv-as="Permanent Upazila / City"
                                    data-vv-name="permanent_upazila_id" @change="getUnion('permanent')">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in permanentUpazilas" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('permanent_upazila_id')" class="invalid-feedback">
                                {{ vvErrors.first("permanent_upazila_id") }}
                            </div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Permanent Union / Thana</label>
                            <select v-model.number="formData.permanent_union_id"
                                    :class="[this.vvErrors.has('permanent_union_id') ? 'is-invalid' : '']"
                                    class="form-control form-control-sm rounded-0" data-vv-as="Present District"
                                    data-vv-name="permanent_union_id">
                                <option value="">Select One</option>
                                <option v-for="(item,index) in permanentUnions" :key="index" :value="item.id">
                                    {{ item.name }}
                                </option>
                            </select>
                            <div v-show="vvErrors.has('permanent_union_id')" class="invalid-feedback">
                                {{ vvErrors.first("permanent_union_id") }}
                            </div>
                        </div>
                    </div>
                    <div class="p-1">
                        <div class="bg-gray-100">
                            <label class="mb-0 pl-1">Permanent Post Code</label>
                            <input v-model.number="formData.permanent_post_code" v-validate="'numeric|min:2|max:6'"
                                   :class="[this.vvErrors.has('permanent_post_code') ? 'is-invalid' : '']"
                                   class="form-control form-control-sm rounded-0" data-vv-as="Permanent Post Code"
                                   data-vv-name="permanent_post_code" type="text"/>
                            <div v-show="vvErrors.has('permanent_post_code')" class="invalid-feedback">
                                {{ vvErrors.first("permanent_post_code") }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 offset-md-9">
                <button class="btn btn-brand btn-czm-green btn-sm pull-right" style="margin-bottom: 4px"
                        @click="addMustahiq"><i class="fa fa-plus"></i> <span>Add Mustahiq</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Select2 from "v-select2-component";

export default {
    name: "PersonalCreateC",
    components: {Select2},
    data() {
        return {
            picturePreview: "",
            formData: {
                picture: "",
                mobile: "",
                alternate_mobile: "",
                emergency_mobile: "",
                marital_status: "Unmarried",
                spouse_name: "",
                spouse_living_status: "Alive",
                spouse_mobile: "",
                highest_education_level: "Uneducated",
                vocational_haves: [],
                vocational_needs: [],
                skill_haves: [],
                skill_needs: [],
                is_earn_ability: 0,
                name: "",
                gender: "",
                pregnancy_status: "None",
                is_birth_date: 1,
                birth_date: "",
                age: "",
                is_orphan: 0,
                orphan_type: "",
                religion: "",
                blood_group: "Unknown",
                email: "",
                nid: "",
                passport: "",
                birth_certificate: "",
                reference_number: "",
                father_name: "",
                father_living_status: "Alive",
                father_mobile: "",
                mother_name: "",
                mother_living_status: "Alive",
                mother_mobile: "",
                relation_with_family_head: "",
                occupation_id: "",
                monthly_income: "",
                remarks: "",
                is_disability: 0,
                disability_id: "",
                is_disease: 0,
                disease_id: "",
                is_disease_regular_medicine: 0,
                present_address: "",
                present_district_id: "",
                present_upazila_id: "",
                present_union_id: "",
                present_post_code: "",
                is_permanent_as_present: 1,
                permanent_address: "",
                permanent_district_id: "",
                permanent_union_id: "",
                permanent_upazila_id: "",
                permanent_post_code: "",
            },
            presentUpazilas: [],
            presentUnions: [],
            permanentUpazilas: [],
            permanentUnions: [],
        };
    },
    methods: {
        removeMustahiq(item, index) {
            Swal.fire({
                title: "Are you sure?",
                html: `<p style="color:#3085d6">"${item.name}"</p>You won't be able to revert this!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, remove it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$parent.formData.mustahiqs.splice(index, 1);
                }
            });
        },
        __newMustahiqObject(data) {
            let mustahiq = {};
            for (let key in data) {
                mustahiq[key] = data[key];
            }
            return mustahiq;
        },
        __resetFormData() {
            this.picturePreview = null;
            Object.keys(this.formData).forEach(key => this.formData[key] = "")
            this.formData.marital_status = "Unmarried";
            this.formData.spouse_living_status = "Alive";
            this.formData.highest_education_level = "Uneducated";
            this.formData.vocational_haves = [];
            this.formData.vocational_needs = [];
            this.formData.skill_haves = [];
            this.formData.skill_needs = [];
            this.formData.is_earn_ability = 0;
            this.formData.pregnancy_status = "None";
            this.formData.is_birth_date = 1;
            this.formData.is_orphan = 0;
            this.formData.blood_group = "Unknown";
            this.formData.father_living_status = "Alive";
            this.formData.mother_living_status = "Alive";
            this.formData.is_disability = 0;
            this.formData.is_disease = 0;
            this.formData.is_disease_regular_medicine = 0;
            this.formData.is_permanent_as_present = 1;
            $("#birth_date").datepicker("update", '');
            this.formData.age = '';
            this.$validator.reset();
        },
        addMustahiq() {
            let _this = this;
            _this.$validator.validateAll().then((result) => {
                if (result) {
                    this.$emit('mustahiq-add', this.__newMustahiqObject(this.formData));
                    _this.__resetFormData();
                }
            });
        },
        getUpazila(key) {
            let _this = this;
            let id;
            if ("permanent" == key) {
                this.formData.permanent_upazila_id = "";
                this.formData.permanent_union_id = "";
                id = this.formData.permanent_district_id;
            } else {
                this.formData.present_upazila_id = "";
                this.formData.present_union_id = "";
                id = this.formData.present_district_id;
            }
            axios.post(this.$parent.routes.upazilaSearch, {district_id: id,})
                .then((res) => {
                    if (res.data) {
                        if ("permanent" == key) {
                            _this.permanentUpazilas = res.data;
                        } else {
                            _this.presentUpazilas = res.data;
                        }
                    } else {
                        _this.loading = false;
                        toastr.error(res.data.message, "Warning");
                    }
                    _this.loading = false;
                }).catch((err) => {
                toastr.error(err, "Error");
                _this.loading = false;
            });
        },
        getUnion(key) {
            let _this = this;
            let id;
            if ("permanent" == key) {
                this.formData.permanent_union_id = "";
                id = this.formData.permanent_upazila_id;
            } else {
                this.formData.present_union_id = "";
                id = this.formData.present_upazila_id;
            }
            axios.post(this.$parent.routes.unionSearch, {upazila_id: id,}).then((res) => {
                if (res.data) {
                    if ("permanent" == key) {
                        _this.permanentUnions = res.data;
                    } else {
                        _this.presentUnions = res.data;
                    }
                } else {
                    _this.loading = false;
                    toastr.error(res.data.message, "Warning");
                }
                _this.loading = false;
            }).catch((err) => {
                toastr.error(err, "Error");
                _this.loading = false;
            });
        },
        checkBirthDate() {
            let _this = this;
            if (_this.formData.is_birth_date) {
                _this.formData.age = '';
            } else {
                $("#birth_date").datepicker("update", _this.formData.birth_date = '');
            }
        },
        checkAddress() {
            let _this = this;
            _this.formData.permanent_address = "";
            _this.formData.permanent_district_id = "";
            _this.formData.permanent_upazila_id = "";
            _this.formData.permanent_union_id = "";
            _this.formData.permanent_post_code = "";
            if (_this.formData.is_permanent_as_present) {
                _this.formData.permanent_address =
                    _this.formData.present_address;
                _this.formData.permanent_district_id =
                    _this.formData.present_district_id;
                _this.formData.permanent_union_id =
                    _this.formData.permanent_union_id;
                _this.formData.permanent_post_code =
                    _this.formData.present_post_code;
                _this.formData.permanent_upazila_id =
                    _this.formData.present_upazila_id;
            }
        },
        chooseFilePicture() {
            document.getElementById("fileUploadPicture").click();
        },
        onFileChangePicture(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            this.createPicture(files[0]);
        },
        createPicture(file) {
            let _this = this;
            let image = new Image();
            let reader = new FileReader();
            reader.addEventListener("load", function () {
                _this.picturePreview = reader.result;
            }.bind(this), false);
            if (file) {
                if (/\.(jpg|png|jpeg)$/i.test(file.name)) {
                    if (file.size < 153600) {
                        reader.readAsDataURL(file);
                        _this.formData.picture = file;
                    } else {
                        Swal.fire("Invalid file size!", "max-size:100kb", "warning");
                        this.formData.picture = null;
                        _this.picturePreview = null;
                    }
                } else {
                    Swal.fire(
                        "Invalid file type!",
                        "Select in - jpeg,jpg,png",
                        "warning"
                    );
                    this.formData.picture = null;
                    _this.picturePreview = null;
                }
            }
        },
        removePicture() {
            this.formData.picture = null;
            this.picturePreview = null;
        }
    },
    mounted() {
        let _this = this;
        $(".datepicker").datepicker({
            todayHighlight: true,
            format: "yyyy-mm-dd",
            startDate: "-200y",
            autoclose: true,
        }).on("changeDate", (event) => {
            let value = event.currentTarget.value;
            switch (event.currentTarget.name) {
                case "birth_date":
                    _this.formData.birth_date = value;
                    break;
            }
        });
    },
    computed: {
        computeRelations() {
            let flag = false;
            let types = this.$parent.initData.familyRelationTypes;
            if (Array.isArray(this.$parent.formData.mustahiqs) && this.$parent.formData.mustahiqs.length > 0) {
                flag = this.$parent.formData.mustahiqs.some(item => 'Self' == item.relation_with_family_head);
            }
            return flag ? Object.keys(types).filter(key => key != 0).reduce((res, key) => (res[key] = types[key], res), {}) : types;
        }
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

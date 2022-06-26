<template>
    <form class="form-horizontal" v-on:submit.prevent="updateFamilyInfo()">
        <div class="row">
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Family Headed By</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.family_headed_by"
                                :class="[(vvErrors.has('family_headed_by') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Family Headed By"
                                data-vv-name="family_headed_by">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.familyHeadedByTypes" :key=item
                                    :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('family_headed_by')" class="invalid-feedback">
                            {{ vvErrors.first('family_headed_by') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">House Land Type</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.house_land_type"
                                :class="[(vvErrors.has('house_land_type') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="House Land Type"
                                data-vv-name="house_land_type">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.houseLandTypes" :key=item :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('house_land_type')" class="invalid-feedback">
                            {{ vvErrors.first('house_land_type') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">House Type</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.house_type"
                                :class="[(vvErrors.has('house_type') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="House Type"
                                data-vv-name="house_type">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.houseTypes" :key=item :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('house_type')" class="invalid-feedback">
                            {{ vvErrors.first('house_type') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">House Location</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.house_location"
                                :class="[(vvErrors.has('house_location') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="House location"
                                data-vv-name="house_location">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.houseLocations" :key=item :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('house_location')" class="invalid-feedback">
                            {{ vvErrors.first('house_location') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Drinking Water</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.drinking_water"
                                :class="[(vvErrors.has('drinking_water') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Drinking Water"
                                data-vv-name="drinking_water">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.drinkingWaterSources" :key=item
                                    :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('drinking_water')" class="invalid-feedback">
                            {{ vvErrors.first('drinking_water') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Other Uses Water</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.other_water"
                                :class="[(vvErrors.has('other_water') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Other uses water"
                                data-vv-name="other_water">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.otherWaterSources" :key=item
                                    :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('other_water')" class="invalid-feedback">
                            {{ vvErrors.first('other_water') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Toilet Type</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.toilet_type"
                                :class="[(vvErrors.has('toilet_type') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="Toilet Type"
                                data-vv-name="toilet_type">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.toiletTypes" :key=item :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('toilet_type')" class="invalid-feedback">
                            {{ vvErrors.first('toilet_type') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Toilet Ownership</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.toilet_owner"
                                :class="[(vvErrors.has('toilet_owner') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="Toilet owner"
                                data-vv-name="toilet_owner">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.toiletOwnershipTypes" :key=item
                                    :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('toilet_owner')" class="invalid-feedback">
                            {{ vvErrors.first('toilet_owner') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Cooking Fuel</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.cooking_fuel"
                                :class="[(vvErrors.has('cooking_fuel') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="Cooking Fuel"
                                data-vv-name="cooking_fuel">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.cookingFuelTypes" :key=item
                                    :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('cooking_fuel')" class="invalid-feedback">
                            {{ vvErrors.first('cooking_fuel') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Electricity Connectivity</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="infoFormData.electricity_connectivity"
                                :class="[(vvErrors.has('electricity_connectivity') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Electricity Connectivity"
                                data-vv-name="electricity_connectivity">
                            <option value="">Select One</option>
                            <option v-for="item in $parent.initData.electricityConnectivityTypes" :key=item
                                    :value=item>
                                {{ item }}
                            </option>
                        </select>
                        <div v-if="vvErrors.has('electricity_connectivity')" class="invalid-feedback">
                            {{ vvErrors.first('electricity_connectivity') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group m-0 p-0">
                    <label class="czm-xs">Total Room </label>
                    <div class="input-group input-group-sm">
                        <input v-model.number="infoFormData.total_room" v-validate="'numeric|max_value:20'"
                               :class="[(vvErrors.has('total_room') ? 'is-invalid' : '')]"
                               class="form-control form-control-sm rounded-0" data-vv-as="total room"
                               data-vv-name="total_room" type="text">
                        <div v-if="vvErrors.has('total_room')" class="invalid-feedback">
                            {{ vvErrors.first('total_room') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group m-0 p-0">
                    <label class="czm-xs">Family Reference Number</label>
                    <div class="input-group input-group-sm">
                        <input v-model="infoFormData.family_reference_number"
                               v-validate="'name_with_number|max:20'"
                               :class="[(vvErrors.has('family_reference_number') ? 'is-invalid' : '')]"
                               class="form-control form-control-sm rounded-0"
                               data-vv-as="family reference number"
                               data-vv-name="family_reference_number" type="text">
                        <div v-if="vvErrors.has('family_reference_number')" class="invalid-feedback">
                            {{ vvErrors.first('family_reference_number') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="relationFormData.length > 0" class="mt-3">
            <div class="row">
                <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="table-responsive-sm">
                        <table class="table table-sm table-stripe">
                            <thead class="bg-gray-100">
                            <tr>
                                <th>Sl.</th>
                                <th>Mustahiq Name</th>
                                <th>Relation With Family Head</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item,index) in relationFormData" :key=index
                                :class="'Self'==item.relation_with_family_head?'bg-gray-200':''">
                                <td>{{ 1 + index }}</td>
                                <td>{{ item.mustahiq_name }}</td>
                                <td>
                                    <select v-model.number="item.relation_with_family_head"
                                            v-validate="'required'"
                                            :class="[(vvErrors.has(`${item.mustahiq_id}-relation`) ? 'is-invalid' : '')]"
                                            :data-vv-as="`${item.mustahiq_name} relation`"
                                            :data-vv-name="`${item.mustahiq_id}-relation`"
                                            class="form-control form-control-sm rounded-0">
                                        <option value="">Select One</option>
                                        <option v-for="item in $parent.initData.familyRelationTypes"
                                                :key=item :value=item> {{ item }}
                                        </option>
                                    </select>
                                    <div v-if="vvErrors.has(`${item.mustahiq_id}-relation`)"
                                         class="invalid-feedback">
                                        {{ vvErrors.first(`${item.mustahiq_id}-relation`) }}
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3 col-lg-3 col-md-3 col-sm-3 offset-9">
                <button class="btn btn-brand btn-czm-blue btn-sm pull-right" type="submit">
                    <i class="fa fa-save"></i>
                    <span>Update Family Info</span>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "FamilyInfoEditC",
    data() {
        return {
            infoFormData: {
                family_headed_by: '',
                house_land_type: '',
                house_type: '',
                house_location: '',
                drinking_water: '',
                other_water: '',
                toilet_type: '',
                toilet_owner: '',
                cooking_fuel: '',
                electricity_connectivity: '',
                total_room: '',
                family_reference_number: '',
            },
            relationFormData: []
        }
    },
    methods: {
        updateFamilyInfo() {
            let _this = this;
            this.$validator.validateAll().then((result) => {
                if (result) {
                    _this.loading = true;
                    axios.put(this.$parent.routes.info, {mustahiqs: _this.relationFormData, ..._this.infoFormData}).then((res) => {
                        if (res.data.success) {
                            toastr.success(res.data.success, "Success");
                            window.location.href = this.$parent.routes.viewAll;
                        } else {
                            toastr.error(res.data.message, "Warning");
                        }
                        _this.loading = false;
                    }).catch((error) => {
                        if (error.response) {
                            toastr.error(error.response.data.message, "Error");
                            if (error.response && error.response.data.errors) {
                                this.$setErrorsFromLaravel(error.response.data);
                            }
                        } else {
                            toastr.error(error.message, "Error");
                        }
                        _this.loading = false;
                    });
                }
            });
        }
    },
    created() {
        this.infoFormData.family_headed_by = this.$parent.family.family_headed_by ?? '';
        this.infoFormData.house_land_type = this.$parent.family.house_land_type ?? '';
        this.infoFormData.house_type = this.$parent.family.house_type ?? '';
        this.infoFormData.house_location = this.$parent.family.house_location ?? '';
        this.infoFormData.drinking_water = this.$parent.family.drinking_water ?? '';
        this.infoFormData.other_water = this.$parent.family.other_water ?? '';
        this.infoFormData.toilet_type = this.$parent.family.toilet_type ?? '';
        this.infoFormData.toilet_owner = this.$parent.family.toilet_owner ?? '';
        this.infoFormData.cooking_fuel = this.$parent.family.cooking_fuel ?? '';
        this.infoFormData.electricity_connectivity = this.$parent.family.electricity_connectivity ?? '';
        this.infoFormData.total_room = this.$parent.family.total_room ?? '';
        this.infoFormData.family_reference_number = this.$parent.family.family_reference_number ?? '';
        this.$parent.family.members.forEach(item => {
            this.relationFormData.push({
                mustahiq_id: item.mustahiq_id,
                mustahiq_name: item.mustahiq ? item.mustahiq.name : '',
                relation_with_family_head: item.relation_with_family_head
            })
        });
    }
}
</script>

<style scoped>
</style>

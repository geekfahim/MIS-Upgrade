<template>
    <div class="card-body p-0">
        <div class="row">
            <div class="col-3 col-lg-3 col-md-3 col-sm-4">
                <div class="form-group p-0 m-0">
                    <label class="czm-xs">Family Headed By</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.family_headed_by"
                                :class="[(vvErrors.has('family_headed_by') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Family Headed By"
                                data-vv-name="family_headed_by">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.familyHeadedByTypes" :key=index
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
                    <label class="czm-xs">House Land Ownership Type</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.house_land_type"
                                :class="[(vvErrors.has('house_land_type') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="House Land Type"
                                data-vv-name="house_land_type">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.houseLandTypes" :key=index :value=item>
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
                    <label class="czm-xs">Family House Type</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.house_type"
                                :class="[(vvErrors.has('house_type') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="House Type"
                                data-vv-name="house_type">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.houseTypes" :key=index :value=item>
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
                        <select v-model.number="$parent.formData.house_location"
                                :class="[(vvErrors.has('house_location') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="House location"
                                data-vv-name="house_location">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.houseLocations" :key=index :value=item>
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
                    <label class="czm-xs">Drinking Water Supply</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.drinking_water"
                                :class="[(vvErrors.has('drinking_water') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Drinking Water"
                                data-vv-name="drinking_water">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.drinkingWaterSources" :key=index
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
                    <label class="czm-xs">Other Uses Water Source</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.other_water"
                                :class="[(vvErrors.has('other_water') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Other uses water"
                                data-vv-name="other_water">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.otherWaterSources" :key=index :value=item>
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
                    <label class="czm-xs">Family Toilet Type</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.toilet_type"
                                :class="[(vvErrors.has('toilet_type') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="Toilet Type"
                                data-vv-name="toilet_type">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.toiletTypes" :key=index :value=item>
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
                        <select v-model.number="$parent.formData.toilet_owner"
                                :class="[(vvErrors.has('toilet_owner') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="Toilet owner"
                                data-vv-name="toilet_owner">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.toiletOwnershipTypes" :key=index
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
                    <label class="czm-xs">Cooking Fuel Source</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.cooking_fuel"
                                :class="[(vvErrors.has('cooking_fuel') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0" data-vv-as="Cooking Fuel"
                                data-vv-name="cooking_fuel">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.cookingFuelTypes" :key=index :value=item>
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
                    <label class="czm-xs">Electricity Connectivity Nature</label>
                    <div class="input-group input-group-sm">
                        <select v-model.number="$parent.formData.electricity_connectivity"
                                :class="[(vvErrors.has('electricity_connectivity') ? 'is-invalid' : '')]"
                                class="form-control form-control-sm rounded-0"
                                data-vv-as="Electricity Connectivity"
                                data-vv-name="electricity_connectivity">
                            <option value="">Select One</option>
                            <option v-for="(item,index) in $parent.initData.electricityConnectivityTypes" :key=index
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
                    <label class="czm-xs">Total Number of Room </label>
                    <div class="input-group input-group-sm">
                        <input v-model.number="$parent.formData.total_room" v-validate="'numeric|max_value:20'"
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
                        <input v-model="$parent.formData.family_reference_number"
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
    </div>
</template>

<script>
export default {
    name: "FamilyInfoCreateC"
};
</script>
<style scoped>
</style>

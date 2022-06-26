<template>
    <div>
        <label class="czm-xs">{{ name }}<span v-if="isRequired" class="text-danger">*</span></label>
        <div class="input-group input-group-sm">
            <div class="input-group-prepend">
                <span class="input-group-text">
                  <i class="fa fa-file-text-o"></i>
                </span>
            </div>
            <input v-bind="$attrs" :type="type" :value="value"
                   @input="$emit('update', $event.target.value)"
                   :data-vv-name="name" :data-vv-as="alias"
                   v-validate="rules"
                   :class="[vvErrors.has(name) ? 'is-invalid' : '']"
                   class="form-control form-control-sm rounded-0"/>
            <div class="invalid-feedback" v-show="vvErrors.has(name)">
                {{ vvErrors.first(name) }}
            </div>
        </div>
        <!--        <input v-bind="$attrs" :type="type" :value="value"
                       class="form-control form-control-sm rounded-0"
                       :class="[this.vvErrors.has('name') ? 'is-invalid' : '']"
                       @input="$emit('update', $event.target.value)">
                <div class="invalid-feedback" v-show="this.vvErrors.has('name')">
                    {{ this.vvErrors.first("name") }}
                </div>-->
    </div>
</template>

<script>
const TYPES = [
    'text',
    'password',
    'email',
    'number',
    'url',
    'tel',
    'search',
    'color'
]
const includes = types => type => types.includes(type)
export default {
    name: "BaseInput",
    model: {
        prop: "value",
        event: "update"
    },
    props: {
        name: {
            type: String,
            default: ''
        },
        isRequired: {
            type: Boolean,
            default: false
        },
        rules: {
            type: String,
            default: ''
        },
        alias: {
            type: String
        },
        value: {
            type: [String, Number],
            default: ''
        },
        type: {
            type: String,
            default: 'text',
            validator(value) {
                const isValid = includes(TYPES)(value)
                if (!isValid) {
                    console.warn(`allowed types are ${TYPES}`);
                }
                return isValid
            }
        }
    }
}
</script>

<style scoped>

</style>

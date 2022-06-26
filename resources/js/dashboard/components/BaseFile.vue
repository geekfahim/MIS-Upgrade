<template>
    <div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="input-group input-group-sm">
                    <input type="file" accept="image/jpeg,image/jpg,image/png,application/pdf" id="baseFile"
                           @change="fileUpload($event)"/>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <input class="form-control form-control-sm rounded-0 " placeholder="remarks" type="text"
                       v-model="remarks"/>
            </div>
        </div>
        <div class="row" v-show="error">
            <div class="col-12 text-danger mb-2">please select a valid file.</div>
        </div>
        <div>
            <button type="button" class="btn btn-brand btn-sm btn-info" @click="add">
                <i class="fa fa-plus"></i>
                <span>Add ({{ limit }} remaining)</span>
            </button>
        </div>
    </div>
</template>

<script>
const TYPES = ['jpeg', 'jpg', 'png', 'pdf'];
export default {
    name: "BaseFile",
    props: {
        type: {
            type: String,
            default: 'png|jpg|pdf|jpeg',
            validator(value) {
                let isValid = value.split('|').every(item => TYPES.includes(item.toLowerCase()));
                if (!isValid) {
                    console.warn(`allowed types are ${TYPES}`);
                }
                return isValid
            }
        },
        maxSize: {
            type: Number,
            default: 100, //100kb
            validator(value) {
                if (value > 2048) { //2MB
                    console.warn(`allowed max size is 2048kb`);
                    return false
                }
                return true
            }
        },
        limit: {
            type: Number,
            default: 1,
        },
    },
    data() {
        return {
            error: false,
            file: '',
            remarks: ''
        }
    },
    methods: {
        add() {
            this.error = false;
            if (!this.file) {
                return this.error = true;
            }
            this.$emit('addFile', this.file, this.remarks)
            this.reset();
        },
        reset() {
            this.file = '';
            this.remarks = '';
            document.getElementById('baseFile').value = null;
        },
        fileUpload(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) return;
            if (files[0].name.match(new RegExp('\.(' + this.type + ')', 'i'))) {
                if (files[0].size < (this.maxSize * 1024)) {
                    this.file = files[0];
                } else {
                    Swal.fire("Invalid file size!", `Your file size is ${(files[0].size / 1024).toFixed(2)}kb, allowed max-size:${this.maxSize}kb`, "warning");
                    document.getElementById('baseFile').value = null;
                    this.file = '';
                }
            } else {
                Swal.fire("Invalid file type!", `allowed types: ${this.type.split('|').join(',')}`, "warning");
                document.getElementById('baseFile').value = null;
            }
        },
    }
}
</script>

<style scoped>

</style>
